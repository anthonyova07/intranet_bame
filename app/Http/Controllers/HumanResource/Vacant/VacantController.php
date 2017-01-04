<?php

namespace Bame\Http\Controllers\HumanResource\Vacant;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Notification\Notification;
use Bame\Models\HumanResource\Vacant\Vacant;
use Bame\Models\HumanResource\Vacant\Applicant\Applicant;
use Bame\Http\Requests\HumanResource\Vacant\VacantRequest;
use Bame\Http\Requests\HumanResource\Vacant\ApplicantRequest;

class VacantController extends Controller
{
    public function index(Request $request)
    {
        $vacancies = Vacant::orderBy('created_at', 'desc');

        if ($request->term) {
            $vacancies->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->term . '%')
                    ->orWhere('name', 'like', '%' . cap_str($request->term) . '%')
                    ->orWhere('detail', 'like', '%' . $request->term . '%')
                    ->orWhere('detail', 'like', '%' . cap_str($request->term) . '%');
            });
        }

        if ($request->date_from) {
            $vacancies->where(function ($query) use ($request) {
                $query->where('created_at', '>=', $request->date_from . ' 00:00:00');
            });
        }

        if ($request->date_to) {
            $vacancies->where(function ($query) use ($request) {
                $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
            });
        }

        $vacancies = $vacancies->paginate();

        $applicants_eligible = Applicant::where('is_eligible_for_vacancies', true)->get();

        return view('human_resources.vacant.index')
            ->with('applicants_eligible', $applicants_eligible)
            ->with('vacancies', $vacancies);
    }

    public function create()
    {
        return view('human_resources.vacant.create');
    }

    public function store(VacantRequest $request)
    {
        $vacant = new Vacant;

        $vacant->id = uniqid(true);
        $vacant->name = clear_tag(htmlentities($request->name));
        $vacant->detail = $request->detail;
        $vacant->is_active = $request->is_active ? true : false;
        $vacant->created_by = session()->get('user');

        $vacant->save();

        do_log('Creó la Vacante ( titulo:' . strip_tags($request->name) . ' )');

        $noti = new Notification('global');
        $noti->create('Nueva Vacante', $vacant->name, route('home.vacant', ['id' => $vacant->id]));
        $noti->save();

        return redirect(route('human_resources.vacant.index'))->with('success', 'La vacante fue creada correctamente.');
    }

    public function show($id)
    {
        $vacant = Vacant::find($id);

        if (!$vacant) {
            return redirect()->with('warning', 'Esta vacante no existe!');
        }

        $applicants = Applicant::where('vacant_id', $vacant->id)->get();

        return view('human_resources.vacant.show')
            ->with('vacant', $vacant)
            ->with('applicants', $applicants);
    }

    public function edit($id)
    {
        $vacant = Vacant::find($id);

        if (!$vacant) {
            return back()->with('warning', 'Esta vacante no existe!');
        }

        return view('human_resources.vacant.edit')
            ->with('vacant', $vacant);
    }

    public function update(VacantRequest $request, $id)
    {
        $vacant = Vacant::find($id);

        if (!$vacant) {
            return back()->with('warning', 'Esta vacante no existe!');
        }

        $vacant->name = clear_tag(htmlentities($request->name));
        $vacant->detail = $request->detail;
        $vacant->is_active = $request->is_active ? true : false;
        $vacant->updated_by = session()->get('user');

        $vacant->save();

        do_log('Editó la vacante ( titulo:' . strip_tags($vacant->name) . ' )');

        return redirect(route('human_resources.vacant.index'))->with('success', 'La vacante ha sido modificado correctamente.');
    }

    public function destroy($id)
    {
        $vacant = Vacant::find($id);

        if (!$vacant) {
            return back()->with('warning', 'Esta vacante no existe!');
        }

        $vacant->delete();

        do_log('Eliminó la vacante ( titulo:' . strip_tags($vacant->name) . ' )');

        return back()->with('success', 'La vacante ha sido eliminado correctamente.');
    }

    public function apply(ApplicantRequest $request, $id)
    {
        $vacant = Vacant::where('is_active', true)->find($id);

        if (!$vacant) {
            return back()->with('warning', 'Esta vacante no existe o no esta activa!');
        }

        $curriculum_path = public_path() . '\\files\\human_resources\\curriculums\\';

        $file_name_destination = str_replace('.', '_', session()->get('user')) . '.' . get_extensions_file($request->file('curriculum')->getClientOriginalName());

        if ($vacant->isSubscribe()) {
            $applicant = $vacant->applicants->where('username', session()->get('user'))->first();

            $file_name = $curriculum_path . $applicant->file_name;

            if (file_exists($file_name)) {
                unlink($file_name);
            }

            Applicant::where('vacant_id', $vacant->id)
                ->where('username', session()->get('user'))
                ->update(['file_name' => $file_name_destination]);
        } else {
            $applicant =  new Applicant;

            $applicant->vacant_id = $vacant->id;
            $applicant->username = session()->get('user');
            $applicant->names = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();
            $applicant->file_name = $file_name_destination;
            $applicant->is_eligible_for_vacancies = false;

            $applicant->save();
        }

        if ($request->hasFile('curriculum')) {
            $request->file('curriculum')->move($curriculum_path, $file_name_destination);
        }

        Notification::notifyUsersByPermission('human_resources_vacant', 'Vacante ' . $vacant->name, $applicant->names . ' ha aplicado a esta vacante.');

        return back()->with('success', 'Usted ha aplicado a la vacante correctamente.');
    }

    public function eligible(Request $request, $vacant, $applicant)
    {
        Applicant::where('vacant_id', $vacant)
                ->where('username', $applicant)
                ->update([
                    'is_eligible_for_vacancies' => true,
                    'vacancies_posible' => substr($request->vacancies_posible, 0, 255),
                ]);

        return back()->with('success', 'La información ha sido actualizada correctamente.');
    }
}

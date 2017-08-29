<?php

namespace Bame\Http\Controllers\Extranet;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Extranet\Users;
use Bame\Http\Requests\Extranet\UsersRequest;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $users = Users::orderBy('created_at', 'desc');

        // if ($request->term) {
        //     $users->where(function ($query) use ($request) {
        //         $query->where('title', 'like', '%' . $request->term . '%')
        //             ->orWhere('detail', 'like', '%' . $request->term . '%');
        //     });
        // }
        //
        // if ($request->date_from) {
        //     $users->where('created_at', '>=', $request->date_from . ' 00:00:00');
        // }
        //
        // if ($request->date_to) {
        //     $users->where('created_at', '<=', $request->date_to . ' 23:59:59');
        // }

        $users = $users->paginate();

        return view('extranet.users.index')
            ->with('users', $users);
    }

    public function create()
    {
        return view('extranet.users.create');
    }

    public function store(UsersRequest $request)
    {
        $user = new Users;
        $user->id = uniqid(true);
        $user->busi_id = $request->business;
        $user->full_name = $request->full_name;
        $user->identifica = $request->identification;
        $user->position = $request->position;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->created_by = session()->get('user');
        $user->save();

        do_log('Creó el Usuario Extranet ( username:' . $user->username . ' )');

        return redirect()->route('extranet.users.create')->with('success', 'El Usuario fue creada correctamente.');

    }

    public function show($id)
    {
        return redirect()->route('extranet.users.index');
    }

    public function edit($id)
    {
        $user = Users::find($id);

        if (!$user) {
            return back()->with('warning', 'Este usuario no existe!');
        }

        return view('extranet.users.edit')
            ->with('user', $user);
    }

    public function update(UsersRequest $request, $id)
    {
        $user = Users::find($id);

        if (!$user) {
            return back()->with('warning', 'Este usuario no existe!');
        }

        $user->busi_id = $request->business;
        $user->full_name = $request->full_name;
        $user->identifica = $request->identification;
        $user->position = $request->position;
        $user->username = $request->username;
        $user->updated_by = session()->get('user');
        $user->save();

        do_log('Editó el Usuario Extranet ( username:' . $user->username . ' )');

        return redirect()->route('extranet.users.index')->with('success', 'El Usuario ha sido modificado correctamente.');
    }

    public function destroy($id)
    {
        $user = Users::find($id);

        if (!$user) {
            return back()->with('warning', 'Este usuario no existe!');
        }

        $user->delete();

        do_log('Eliminó el Usuario Extranet ( username:' . $user->username . ' )');

        return redirect(route('extranet.users.index'))->with('success', 'El Usuario ha sido eliminado correctamente.');
    }
}

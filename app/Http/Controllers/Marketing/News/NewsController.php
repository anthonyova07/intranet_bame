<?php

namespace Bame\Http\Controllers\Marketing\News;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use DateTime;
use Bame\Models\Notification\Notification;
use Bame\Models\Marketing\News\News;
use Bame\Http\Requests\Marketing\News\NewsRequest;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $news = News::where('created_by', session()->get('user'));

        if ($request->term) {
            $news->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->term . '%')
                    ->where('detail', 'like', '%' . $request->term . '%');
            });
        }

        if ($request->date_from) {
            $news->where(function ($query) use ($request) {
                $query->where('created_at', '>=', $request->date_from . ' 00:00:00');
            });
        }

        if ($request->date_to) {
            $news->where(function ($query) use ($request) {
                $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
            });
        }

        $news = $news->paginate();

        return view('marketing.news.index')
            ->with('news', $news);
    }

    public function create()
    {
        return view('marketing.news.create');
    }

    public function store(NewsRequest $request)
    {
        $new = new News;
        $new->id = uniqid(true);
        $new->title = clear_tag(htmlentities($request->title));
        $new->detail = htmlentities($request->detail);

        if ($request->hasFile('image')) {
            $file_name_destination = $new->id . '.' . get_extensions_file($request->file('image')->getClientOriginalName());

            $request->file('image')->move(public_path() . '\\marketing\\images\\', $file_name_destination);

            $new->image = '/marketing/images/' . $file_name_destination;
        }

        if ($request->hasFile('image_banner')) {
            $file_name_destination = $new->id . '_banner.' . get_extensions_file($request->file('image_banner')->getClientOriginalName());

            $request->file('image_banner')->move(public_path() . '\\marketing\\images\\', $file_name_destination);

            $new->imgbanner = '/marketing/images/' . $file_name_destination;
        }

        $new->type = $request->type;
        $new->link_name = $request->link_name;
        $new->link = $request->link;
        $new->link_video = $request->link_video;
        $new->is_active = $request->is_active ? true : false;
        $new->created_by = session()->get('user');

        $new->save();

        do_log('Creó la Noticia ( titulo:' . strip_tags($request->title) . ' )');

        $noti = new Notification('global');
        $noti->create('Nueva Noticia', $request->title, route('home.news', ['id' => $new->id]));
        $noti->save();

        return redirect(route('marketing.news.index'))->with('success', 'La noticia fue creada correctamente.');

    }

    public function show($id)
    {
        return redirect(route('marketing.news.index'));
    }

    public function edit($id)
    {
        $new = News::where('created_by', session()->get('user'))->find($id);

        if (!$new) {
            return back()->with('warning', 'Esta noticia no existe!');
        }

        return view('marketing.news.edit')
            ->with('new', $new);
    }

    public function update(NewsRequest $request, $id)
    {
        $new = News::where('created_by', session()->get('user'))->find($id);

        if (!$new) {
            return back()->with('warning', 'Esta noticia no existe!');
        }

        $new->title = clear_tag(htmlentities($request->title));
        $new->detail = htmlentities($request->detail);

        if ($request->hasFile('image')) {
            $file_name = public_path() . str_replace('/', '\\', $new->image);

            if (file_exists($file_name)) {
                unlink($file_name);
            }

            $file_name_destination = $id . '.' . get_extensions_file($request->file('image')->getClientOriginalName());

            $request->file('image')->move(public_path() . '\\marketing\\images\\', $file_name_destination);

            $new->image = '/marketing/images/' . $file_name_destination;
        }

        if ($request->hasFile('image_banner')) {
            $file_name = public_path() . str_replace('/', '\\', $new->imgbanner);

            if (file_exists($file_name) && is_file($file_name)) {
                unlink($file_name);
            }

            $file_name_destination = $id . '_banner.' . get_extensions_file($request->file('image_banner')->getClientOriginalName());

            $request->file('image_banner')->move(public_path() . '\\marketing\\images\\', $file_name_destination);

            $new->imgbanner = '/marketing/images/' . $file_name_destination;
        }

        $new->type = $request->type;
        $new->link_name = $request->link_name;
        $new->link = $request->link;
        $new->link_video = $request->link_video;
        $new->is_active = $request->is_active ? true : false;
        $new->updated_by = session()->get('user');

        if ($request->repost) {
            $new->created_at = new DateTime;
        }

        $new->save();

        do_log('Editó la Noticia ( titulo:' . strip_tags($request->title) . ' )');

        return redirect(route('marketing.news.index'))->with('success', 'La noticia ha sido modificada correctamente.');
    }

    public function destroy($id)
    {
        $new = News::where('created_by', session()->get('user'))->find($id);

        if (!$new) {
            return back()->with('warning', 'Esta noticia no existe!');
        }

        $file_name = public_path() . str_replace('/', '\\', $new->image);

        if (file_exists($file_name)) {
            unlink($file_name);
        }

        $file_name = public_path() . str_replace('/', '\\', $new->imgbanner);

        if (file_exists($file_name)) {
            unlink($file_name);
        }

        $new->delete();

        do_log('Eliminó la Noticia ( titulo:' . strip_tags($new->title) . ' )');

        return redirect(route('marketing.news.index'))->with('success', 'La noticia ha sido eliminada correctamente.');
    }
}

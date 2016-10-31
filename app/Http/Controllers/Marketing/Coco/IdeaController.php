<?php

namespace Bame\Http\Controllers\Marketing\Coco;

use Illuminate\Http\Request;

use Bame\Http\Requests;
use Bame\Http\Controllers\Controller;

use Bame\Models\Marketing\Coco\Idea;

class IdeaController extends Controller
{
    public function index(Request $request)
    {
        $ideas = Idea::orderBy('created_at', 'desc')->paginate();

        return view('marketing.coco.idea.index', [
            'ideas' => $ideas,
        ]);
    }

    public function show($id)
    {
        $idea = Idea::find($id);

        if (!$idea) {
            return back()->with('warning', 'Esta idea no existe!');
        }

        return view('marketing.coco.idea.show', [
            'idea' => $idea,
        ]);
    }
}

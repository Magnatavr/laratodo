<?php

namespace App\Http\Controllers\Task;

use App\Models\Tag;

class CreateController extends BaseController
{
    public function __invoke()
    {
        $tags = Tag::all();
        return view('task.create', compact('tags'));

    }
}

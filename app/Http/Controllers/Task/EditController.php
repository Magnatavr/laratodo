<?php

namespace App\Http\Controllers\Task;

use App\Models\Tag;
use App\Models\Todo;

class EditController extends BaseController
{
    public function __invoke(Todo $todo)
    {
        $tags = Tag::all();

        return view('task.edit', compact('todo', 'tags'));

    }
}

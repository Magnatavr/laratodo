<?php

namespace App\Http\Controllers\Task;

use App\Models\Todo;


class ShowController extends BaseController
{
    public function __invoke(Todo $todo)
    {

        return view('task.show', compact('todo'));

    }
}

<?php

namespace App\Http\Controllers\Task;

use App\Models\Todo;
use Exception;


class DeleteController extends BaseController
{
    public function __invoke(Todo $todo)
    {
        try {
            $this->service->delete($todo);
            return redirect()->route('main.index')->with('success', 'Task deleted successfully.');

        } catch (Exception $e) {
            return back()->with('error', 'Произошла ошибка при удалении задачи.');
        }

    }
}

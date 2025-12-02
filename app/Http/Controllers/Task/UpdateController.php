<?php

namespace App\Http\Controllers\Task;

use App\Http\Requests\Task\UpdateRequest;
use App\Models\Todo;
use Exception;
use Illuminate\Support\Facades\DB;


class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Todo $todo)
    {
        $data = $request->validated();


        try {


            $this->service->update($data, $todo);

            return redirect()->route('main.tasks.show', $todo->id)->with('success', 'Задача успешно изменена!');

        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Ошибка при изменении задачи.');
        }


    }
}

<?php

namespace App\Http\Controllers\Task;

use App\Http\Requests\Task\StoreRequest;
use Exception;


class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        try {

            $this->service->store($data);
            return redirect()->route('main.index')->with('success', 'Задача успешно создана!');

        } catch (Exception $e) {

            return back()->withInput()->with('error', 'Ошибка при создании задачи.');
        }


    }
}

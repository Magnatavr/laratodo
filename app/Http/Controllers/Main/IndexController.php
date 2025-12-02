<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\FilterRequest;
use App\Models\Tag;
use App\Models\Todo;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(FilterRequest $request)
    {

        $data = $request->validated();
        $query = Todo::with('tags');

        if (!empty($data['search'])){
            $query->where('title', 'like', '%'.$data['search'].'%')
            ->orWhere('description', 'like', '%'.$data['search'].'%');
        }


        if (!empty($data['status'])) {
            $query->where('status', $data['status']);
        }

        if(!empty($data['tags'])){
            $query->whereHas('tags', fn($q) => $q->whereIn('tags.id', $data['tags']));
        }

        $todos = $query->orderBy('created_at', 'desc')->paginate(2);
        // Получаем все теги для чекбоксов
        $allTags = Tag::all();

        // Получаем все статусы из базы (distinct)


        return view('main.index', compact('todos', 'allTags'));


    }
}

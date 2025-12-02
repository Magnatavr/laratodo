@extends('layouts.app')

@section('content')
    <div class="container py-5">

        {{-- Форма фильтра (в одном контейнере) --}}
        <form action="{{ route('main.index') }}" method="GET" class="mb-4">
            <div class="row g-2 align-items-center">
                {{-- Поиск --}}
                <div class="col-12 col-md-4">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Поиск по названию или описанию">
                </div>

                {{-- Статусы --}}
                <div class="col-6 col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Все статусы</option>
                        <option value="todo" {{ request('status')=='todo' ? 'selected' : '' }}>В ожидании</option>
                        <option value="in_progress" {{ request('status')=='in_progress' ? 'selected' : '' }}>В процессе</option>
                        <option value="done" {{ request('status')=='done' ? 'selected' : '' }}>Выполнено</option>
                        <option value="archived" {{ request('status')=='archived' ? 'selected' : '' }}>Архив</option>
                    </select>
                </div>

                {{-- Теги (чекбоксы) --}}
                <div class="col-12 col-md-4">
                    <div class="border rounded p-2" style="max-height:120px; overflow:auto;">
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($allTags as $tag)
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="checkbox" name="tags[]"
                                           value="{{ $tag->id }}" id="tag{{ $tag->id }}"
                                        {{ in_array($tag->id, request('tags', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="tag{{ $tag->id }}">
                                        {{ $tag->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Кнопки --}}
                <div class="col-6 col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary">Применить</button>
                </div>
                <div class="col-6 col-md-0 d-grid d-md-none">
                    {{-- На мобильных — кнопка сброса рядом --}}
                    <a href="{{ route('main.index') }}" class="btn btn-outline-secondary">Сброс</a>
                </div>

                {{-- Сброс фильтров (на десктопе справа) --}}
                <div class="col-12 col-md-12 mt-2 d-none d-md-flex justify-content-end">
                    <a href="{{ route('main.index') }}" class="btn btn-link">Сбросить фильтры</a>
                </div>
            </div>
        </form>

        {{-- Заголовок + кнопка --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-semibold mb-0">Мои задачи</h1>
            <a href="{{ route('main.tasks.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <span class="fs-5">＋</span>
                <span>Новая задача</span>
            </a>
        </div>

        {{-- Список задач --}}
        <div class="card shadow-sm">
            @forelse($todos as $todo)
                <div class="card-body border-bottom d-flex justify-content-between align-items-center">
                    <div>
                    <span class="badge
                        @if($todo->status === 'done' || $todo->status === 'completed') bg-success
                        @elseif($todo->status === 'in_progress') bg-warning text-dark
                        @else bg-secondary
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $todo->status)) }}
                    </span>

                        <a href="{{ route('main.tasks.show', $todo) }}" class="ms-3 fw-medium text-decoration-none">
                            {{ $todo->title }}
                        </a>

                        <div class="mt-2">
                            @foreach($todo->tags as $tag)
                                <span class="badge" style="background-color: {{ $tag->color ?? '#ccc' }}">
                                {{ $tag->name }}
                            </span>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('main.tasks.edit', $todo) }}" class="btn btn-sm btn-outline-secondary">Edit</a>

                        <form action="{{ route('main.tasks.delete', $todo) }}" method="POST" onsubmit="return confirm('Вы уверены?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="card-body text-muted">Нет задач</div>
            @endforelse
        </div>

        {{-- Пагинация (центрируем и сохраняем строку запроса) --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $todos->withQueryString()->links() }}
        </div>

    </div>
@endsection

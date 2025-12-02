@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <h1 class="mb-4">Редактировать задачу</h1>

        <form action="{{ route('main.tasks.update', $todo->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            {{-- Название --}}
            <div class="mb-3">
                <label class="form-label">Название *</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $todo->title) }}" required>
                @error('title')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Описание --}}
            <div class="mb-3">
                <label class="form-label">Описание</label>
                <textarea name="description" class="form-control">{{ old('description', $todo->description) }}</textarea>
                @error('description')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Приоритет --}}
            <div class="mb-3">
                <label class="form-label">Приоритет</label>
                <select name="priority" class="form-select">
                    @foreach(['normal'=>'Обычный','low'=>'Низкий','high'=>'Высокий','urgent'=>'Срочный'] as $val=>$label)
                        <option value="{{ $val }}" @selected(old('priority', $todo->priority) === $val)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('priority')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Статус --}}
            <div class="mb-3">
                <label class="form-label">Статус</label>
                <select name="status" class="form-select">
                    @foreach(['todo'=>'В ожидании','in_progress'=>'В процессе','done'=>'Выполнено','archived'=>'Архив'] as $val=>$label)
                        <option value="{{ $val }}" @selected(old('status', $todo->status) === $val)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('status')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Дедлайн --}}
            <div class="mb-3">
                <label class="form-label">Дедлайн</label>
                <input type="datetime-local" name="deadline" class="form-control"
                       value="{{ old('deadline', $todo->deadline?->format('Y-m-d\TH:i')) }}">
                @error('deadline')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Теги --}}
            <div class="mb-3">
                <label class="form-label">Теги</label>
                <div class="row">
                    @foreach($tags as $tag)
                        <div class="col-6">
                            <div class="form-check">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="form-check-input"
                                    @checked(in_array($tag->id, old('tags', $todo->tags->pluck('id')->toArray())))>
                                <label class="form-check-label">{{ $tag->name }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
                @error('tags')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
                @error('tags.*')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Новые вложения --}}
            <div class="mb-3">
                <label class="form-label">Добавить файлы</label>
                <input type="file" name="attachments[]" multiple class="form-control">
                @error('attachments')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
                @error('attachments.*')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Существующие вложения --}}
            <h5>Текущие файлы</h5>
            @forelse($todo->attachments as $file)
                <div>
                    <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank">{{ $file->file_path }}</a>
                </div>
            @empty
                <div class="text-muted">Нет файлов</div>
            @endforelse

            <button class="btn btn-primary mt-4">Сохранить изменения</button>
        </form>

    </div>
@endsection

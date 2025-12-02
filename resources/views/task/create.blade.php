@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <h1 class="mb-4">Создать задачу</h1>

        <form action="{{ route('main.tasks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Название --}}
            <div class="mb-3">
                <label class="form-label">Название задачи *</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                @error('title')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Описание --}}
            <div class="mb-3">
                <label class="form-label">Описание</label>
                <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                @error('description')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Приоритет --}}
            <div class="mb-3">
                <label class="form-label">Приоритет</label>
                <select name="priority" class="form-select">
                    <option value="normal" {{ old('priority') == 'normal' ? 'selected' : '' }}>Обычный</option>
                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Низкий</option>
                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Высокий</option>
                    <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Срочный</option>
                </select>
                @error('priority')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Статус --}}
            <div class="mb-3">
                <label class="form-label">Статус</label>
                <select name="status" class="form-select">
                    <option value="todo" {{ old('status') == 'todo' ? 'selected' : '' }}>В ожидании</option>
                    <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>В процессе</option>
                    <option value="done" {{ old('status') == 'done' ? 'selected' : '' }}>Выполнено</option>
                    <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Архив</option>
                </select>
                @error('status')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Дедлайн --}}
            <div class="mb-3">
                <label class="form-label">Дедлайн</label>
                <input type="datetime-local" name="deadline" class="form-control" value="{{ old('deadline') }}">
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
                                <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                    {{ is_array(old('tags')) && in_array($tag->id, old('tags')) ? 'checked' : '' }}>
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

            {{-- Вложения --}}
            <div class="mb-3">
                <label class="form-label">Вложения (файлы)</label>
                <input type="file" name="attachments[]" multiple class="form-control">
                @error('attachments')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
                @error('attachments.*')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                Создать задачу
            </button>

        </form>
    </div>
@endsection

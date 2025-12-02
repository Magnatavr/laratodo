@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <h1 class="mb-4">{{ $todo->title }}</h1>

        {{-- Статус и приоритет --}}
        <div class="mb-3">
        <span class="badge
            @if($todo->status === 'done') bg-success
            @elseif($todo->status === 'in_progress') bg-warning text-dark
            @else bg-secondary @endif">
            {{ ucfirst($todo->status) }}
        </span>

            <span class="badge bg-info text-dark">
            {{ ucfirst($todo->priority) }}
        </span>
        </div>

        {{-- Описание --}}
        <div class="mb-3">
            <p>{{ $todo->description ?? 'Нет описания' }}</p>
        </div>

        {{-- Дедлайн --}}
        @if($todo->deadline)
            <div class="mb-3">
                <strong>Дедлайн:</strong> {{ $todo->deadline->format('d.m.Y H:i') }}
            </div>
        @endif

        {{-- Теги через implode --}}
        @if($todo->tags->isNotEmpty())
            <div class="mb-3">
                <strong>Теги:</strong>
                <span class="badge bg-secondary">
            {{ $todo->tags->pluck('name')->implode(', ') }}
        </span>
            </div>
        @endif

        {{-- Вложения --}}
        @if($todo->attachments->isNotEmpty())
            <div class="mb-3">
                <strong>Вложения:</strong>
                <ul class="list-group">
                    @foreach($todo->attachments as $file)
                        <li class="list-group-item">
                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                {{ $file->file_path }}
                            </a>
                            <small class="text-muted">({{ $file->file_size }} bytes, {{ $file->file_type }})</small>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Действия --}}
        <div class="mt-4">
            <a href="{{ route('main.tasks.edit', $todo) }}" class="btn btn-primary">Редактировать</a>

            <form action="{{ route('main.tasks.delete', $todo) }}" method="POST" class="d-inline-block">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('Вы уверены?')">Удалить</button>
            </form>

            <a href="{{ route('main.index') }}" class="btn btn-secondary">Назад к списку</a>
        </div>

    </div>
@endsection

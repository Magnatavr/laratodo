<?php

namespace App\Services\Todo;

use App\Models\Todo;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Service
{

    /**
     * @throws Exception
     */
    /**
     * удаление задачи
     */
    public function delete(Todo $todo): void
    {
        DB::beginTransaction();

        try {
            //  Удаляем файлы с диска
            $this->deleteAttachments($todo);
            // удаляем привязанные файлы
            $todo->tags()->detach();
            $todo->subtasks()->delete();
            $todo->comments()->delete();
            $todo->reminders()->delete();
            $todo->logs()->delete();
            $todo->delete();

            DB::commit();


        } catch (Exception $e) {

            DB::rollBack();

            // Логируем, но не показываем пользователю
            Log::error("Ошибка удаления задачи: " . $e->getMessage(), ['todo_id' => $todo->id, 'trace' => $e->getTraceAsString(),]);

            // Пробрасываем исключение наверх
            throw $e;
        }
    }


    /**
     * Создание задачи
     */
    public function store($data): void
    {

        $attachments = $data['attachments'] ?? [];
        $tags = $data['tags'] ?? [];

        unset($data['attachments'], $data['tags']);
        $data['user_id'] = auth()->id();

        DB::beginTransaction();

        try {
            $todo = Todo::create($data);

            if (!empty($tags)) {
                $todo->tags()->sync($tags);
            }

           $this->saveAttachments($todo, $attachments);

            DB::commit();


        } catch (Exception $e) {
            DB::rollBack();

            // Логируем, но не показываем пользователю
            Log::error("Ошибка при создании задачи", [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $data,
            ]);

            // Пробрасываем исключение наверх
            throw $e;
        }
    }

    /**
     * измнения задачи
     */
    public function update(array $data, Todo $todo): void
    {
        $attachments = $data['attachments'] ?? [];
        $tags = $data['tags'] ?? [];

        unset($data['attachments'], $data['tags']);

        DB::beginTransaction();

        try {

            // Обновляем только если есть данные
            if (!empty($data)) {
                $updated = $todo->update($data);
                if ($updated) {
                    Log::info("Задача {$todo->id} обновлена", $data);
                } else {
                    Log::info("Задача {$todo->id} не изменилась");
                }
            }

            // Синхронизируем теги (можно пустой массив)
            $todo->tags()->sync($tags);

            // Работа с файлами только если есть новые
            if (!empty($attachments)) {
                $this->deleteAttachments($todo);
                $this->saveAttachments($todo, $attachments);
            }

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();

            Log::error("Ошибка изменения задачи: " . $e->getMessage(), [
                'todo_id' => $todo->id,
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }


    /**
     * функции помошникни работ с файлами
     */
    private function deleteAttachments(Todo $todo): void
    {
        foreach ($todo->attachments as $attachment) {

            if ($attachment->file_path && Storage::disk('public')->exists($attachment->file_path)) {
                $deleted = Storage::disk('public')->delete($attachment->file_path);
                if (!$deleted) {
                    throw new \Exception("Не удалось удалить файл: " . $attachment->file_path);
                }
            }else{
                throw new \Exception("Не удалось найти и удалить файл: " . $attachment->file_path);
            }
        }

        $todo->attachments()->delete();
    }
    private function saveAttachments(Todo $todo, array $attachments): void
    {
        foreach ($attachments as $file) {
            if ($file->isValid()) {

                $path = $file->store('attachments', 'public');

                $todo->attachments()->create([
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            } else {
                throw new \Exception("Файл недействителен: " . $file->getClientOriginalName());
            }
        }
    }


}

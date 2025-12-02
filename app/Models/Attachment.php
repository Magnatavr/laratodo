<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = ['todo_id', 'file_path', 'file_type', 'file_size'];

    public function todo()
    {
        return $this->belongsTo(Todo::class, 'todo_id', 'id');
    }
}

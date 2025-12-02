<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    protected $fillable = [
        'todo_id', 'title', 'is_completed', 'completed_at', 'position'
    ];

    public function todo()
    {
        return $this->belongsTo(Todo::class , 'todo_id', 'id');
    }
}

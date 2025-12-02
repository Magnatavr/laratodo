<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['todo_id', 'user_id', 'message'];

    public function todo()
    {
        return $this->belongsTo(Todo::class , 'todo_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

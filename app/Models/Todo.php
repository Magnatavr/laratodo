<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{


    protected $fillable = [
        'user_id', 'title', 'description', 'status', 'priority',
        'deadline', 'completed_at', 'position', 'is_favorite', 'repeat_rule'
    ];
    protected $casts = [
        'deadline' => 'datetime',
    ];



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id' , 'id');
    }

    public function subTasks()
    {
        return $this->hasMany(SubTask::class, 'todo_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'todo_tag', 'todo_id', 'tag_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class , 'todo_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'todo_id', 'id');
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class, 'todo_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany(ActivityLog::class, 'todo_id', 'id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    public const TASK_STATUS_NEW = 1;
    public const TASK_STATUS_INPROGRESS = 2;
    public const TASK_STATUS_COMPLETED = 3;
    public const TASK_PRIORITY_LOW = 1;
    public const TASK_PRIORITY_MEDIUM = 2;
    public const TASK_PRIORITY_HIGH = 3;


    public function Project()
    {
        return $this->belongsTo(Project::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}

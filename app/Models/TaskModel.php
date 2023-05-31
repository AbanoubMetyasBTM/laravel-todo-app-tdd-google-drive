<?php

namespace App\Models;

use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskModel extends Model
{
    use HasFactory;

    protected $table = "tasks";
    protected $primaryKey = "task_id";
    protected $fillable = [
        'list_id',
        'task_title', 'task_desc',
        'label_id', 'task_status'
    ];

    public static $statues = [
        "not_started" => "not_started",
        "in_progress" => "in_progress",
        "done"        => "done"
    ];

    protected static function newFactory()
    {
        return TaskFactory::new();
    }

    public static function getTodoListTasks(int $todoListId)
    {
        return self::
        where("list_id", $todoListId)
            ->get();
    }

    public static function saveTask(array $data)
    {
        return self::create([
            'list_id'     => $data["list_id"],
            'task_title'  => $data["task_title"],
            'task_desc'   => $data["task_desc"] ?? "",
            'label_id'    => $data["label_id"] ?? null,
            'task_status' => $data["task_status"] ?? "not_started",
        ]);
    }


    public static function updateTask($obj, $data)
    {
        return $obj->update([
            'task_title'  => $data["task_title"] ?? $obj->task_title,
            'task_desc'   => $data["task_desc"] ?? $obj->task_desc,
            'label_id'    => $data["label_id"] ?? $obj->label_id,
            'task_status' => $data["task_status"] ?? $obj->task_status,
        ]);
    }

}

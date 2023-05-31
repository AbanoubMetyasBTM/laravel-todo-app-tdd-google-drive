<?php

namespace App\Models;

use Database\Factories\TodoListFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoListModel extends Model
{
    use HasFactory;

    protected $table = "todo_lists";
    protected $primaryKey = "list_id";
    protected $fillable = [
        "list_title", "user_id"
    ];

    protected static function newFactory()
    {
        return TodoListFactory::new();
    }

    public static function getUserLists(int $userId)
    {
        return self::where("user_id", $userId)->get();
    }

    public static function createNewList($userId, $listTitle)
    {
        return self::create([
            "user_id"    => $userId,
            "list_title" => $listTitle,
        ]);
    }

    public static function getUserListId(int $userId, int $listId){
        return self::
            where("user_id", $userId)
            ->where("list_id", $listId)
            ->limit(1)
            ->get()->first();
    }

}

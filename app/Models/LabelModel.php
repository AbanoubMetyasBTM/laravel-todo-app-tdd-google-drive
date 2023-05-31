<?php

namespace App\Models;

use Database\Factories\LabelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabelModel extends Model
{
    use HasFactory;

    protected $table = "labels";
    protected $primaryKey = "label_id";
    protected $fillable = [
        'user_id',
        'label_title', 'label_color',
    ];

    protected static function newFactory()
    {
        return LabelFactory::new();
    }

    public static function createNewLabel($data)
    {
        return self::create([
            'user_id'     => $data["user_id"],
            'label_title' => $data["label_title"],
            'label_color' => $data["label_color"],
        ]);
    }


    public static function updateLabel($obj, $data)
    {
        return $obj->update([
            'label_title' => $data["label_title"],
            'label_color' => $data["label_color"],
        ]);
    }

    public static function getUserLabels(int $userId){
        return self::
           where("user_id", $userId)
            ->get();
    }

    public static function getUserLabel(int $userId, int $labelId){
        return self::
           where("user_id", $userId)
            ->where("label_id", $labelId)
            ->limit(1)
            ->get()->first();
    }

}

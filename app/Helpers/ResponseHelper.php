<?php


namespace App\Helpers;


class ResponseHelper
{

    public static function returnSuccess($data, $status = 200, $message = "")
    {
        return response([
            "message" => $message,
            "data"    => $data,
        ], $status);
    }

    public static function returnError($message, $status = 200)
    {
        return response([
            "message" => $message,
            "errors"  => [],
        ], $status);
    }

}

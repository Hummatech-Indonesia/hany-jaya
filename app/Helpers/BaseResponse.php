<?php

namespace App\Helpers;


class BaseResponse {

    /**
     * Make base response 
     */

    private $status, $message, $data;
    
    public function __construct(?int $status, string $message, mixed $data)
    {
        $this->status = $status ?? 200;
        $this->message = $message;
        $this->data = $data;
    }

    public static function Ok(string $message, mixed $data){
        return response()->json([
            "status" => 200,
            "message" => $message,
            "data" => $data
        ]);
    }

    public static function Error(string $message){
        return response()->json([
            "status" => 500,
            "message" => $message,
            "data" => null
        ]);
    }

    public static function Custom(int $status, string $message, mixed $data){
        return response()->json([
            "status" => $status,
            "message" => $message,
            "data" => $data
        ]);
    }
}

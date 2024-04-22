<?php

namespace App\Helpers;

class ApiFormatter {
    protected static $response = [
        "status" => null,
        "message" => null,
        "data" => null,
    ];

    public static function sendResponse($status = null, $message = null, $data = []) {
        self::$response['status'] = $status;
        self::$response['message'] = $message;
        self::$response['data'] = $data;
        
        return response()->json(self::$response, self::$response['status']);
    }
}

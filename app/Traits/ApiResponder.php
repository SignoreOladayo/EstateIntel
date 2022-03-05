<?php
namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponder
{
    public function successCall($status_code, $status, $data = [], $message = null): JsonResponse
    {
        if(!is_null($message)){
            $response = ['status_code' => $status_code, 'status' => $status, 'message' => $message, 'data' =>  $data];
        }else {
            $response = ['status_code' => $status_code, 'status' => $status, 'data' =>  $data];
        }

        return response()->json($response);
    }

    public function badCall($status_code, $status, $error, $reason){
        $response = ["status_code" => $status_code, "status" => $status, "error" => $error, "reason" => $reason];

        return response()->json($response);
    }
}

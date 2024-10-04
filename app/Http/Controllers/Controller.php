<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function successResponse($message = '', $data = [])
    {
        return response()->json(array_merge([
            'status' => 'success',
            'message' => $message,
        ], $data));
    }

    public function errorResponse($status = 400, $message = '', $data = [])
    {
        return response()->json(array_merge([
            'status' => 'fail',
            'message' => $message,
        ], $data), $status);
    }

    public function exceptionResponse(Exception $e)
    {
        if(env('APP_DEBUG') == true) {
            // set exception error for data is used
            if(get_class($e) == QueryException::class && $e->getCode() == 23000) {
                return response()->json([
                    'status' => '<fai></fai>l',
                    'message' => 'Data tidak dapat dihapus karena masih digunakan di data lain',
                    'real_error' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ], 500);
            } else if (get_class($e) == QueryException::class && $e->getCode() == '23505') {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Terdapat duplikasi data',
                ], 500);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage() ?? 'Unknown error',
                ], 500);
            }
        } else {
            return response()->json([
                'status' => 'fail',
                'message' => 'Server error',
            ], 500);
        }
    }
}

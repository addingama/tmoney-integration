<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Default formatter for error response API
     *
     * @param Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseError(Exception $e) {
        return response()->json(['error' => true, 'code' => $e->getCode(), 'message' => $e->getMessage()], $e->getCode());
    }


    public function responseSuccess($response) {
        return response()->json(['error' => false, 'response' => $response]);
    }
}

<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param Request $request
     * @param Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseError(Request $request, Exception $e)
    {
        Log::error($e);
        return response()->json([
            'error' => true,
            'code' => $e->getCode(),
            'url' => $request->fullUrl(),
            'message' => $e->getMessage()
        ], $e->getCode());
    }


    /**
     * @param Request $request
     * @param $response
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseSuccess(Request $request, $response)
    {
        return response()->json([
            'error' => false,
            'url' => $request->fullUrl(),
            'response' => $response
        ]);

    }
}

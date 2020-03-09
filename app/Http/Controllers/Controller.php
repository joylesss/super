<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $data
     * @param int $statusCode
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond($data, $statusCode = 200, $headers = [])
    {
        return response()->json($data, $statusCode, $headers);
    }

    /**
     * @param $data
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondSuccess($data, $statusCode = 200)
    {
        return $this->respond([
            'status'    => true,
            'content'   => $data,
            'message'   => 'Success'
        ], $statusCode);
    }

    protected function respondError($message = 'Bad request', $statusCode = 400)
    {
        return $this->respond([
            'status'    => false,
            'errors'    => $message,
        ], $statusCode);
    }
}

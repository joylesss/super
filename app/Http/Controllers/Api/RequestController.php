<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\RequestService;

class RequestController extends Controller
{
    protected $requestService;

    public function __construct(RequestService $requestService)
    {
        //
        $this->requestService = $requestService;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function infoApp()
    {
        return $this->respondSuccess($this->requestService->infoApp($_GET));
    }

    /**
     * @param $app_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function infoQuestion($app_id)
    {
        //
        return $this->respondSuccess($this->requestService->infoQuestion($app_id));
    }

    /**
     * @param $params
     * @return \Illuminate\Http\JsonResponse
     */
    public function infoResult()
    {
        return $this->respondSuccess($this->requestService->infoResult($_POST));
    }

    /**
     * @param $app_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function infoScore($app_id)
    {
        //
        return $this->respondSuccess($this->requestService->infoScore($app_id));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestValidation $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        //
        return $this->requestService->index($user_id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return $this->UserService->destroy($id);
    }

    public function search(Request $request)
    {
        //
    }
}

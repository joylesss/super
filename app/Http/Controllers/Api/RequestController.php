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

    public function pusher()
    {
        $beamsClient = new \Pusher\PushNotifications\PushNotifications(array(
            "instanceId" => "17fc8ca2-b1fd-43d0-83c4-7ea57605d8d6",
            "secretKey" => "B4CB0171333EF30DA3BAF4480FBBE72B37A06496AD7A0C9648E09FEDEEE0D4F3",
            /*"instanceId" => "6d56b9b9-2f29-49a8-bc43-6e8bf400cae6",
            "secretKey" => "F948DAB7DC13143E6AD1E5778AD4C95FC5C97C3C355C534BE74F8FA68AC5512D",*/
        ));

        return $beamsClient->publishToInterests(
            array("debug-test"),
//            array("2930164663711173"),
            array(
                "fcm" => array(
                    "notification" => array(
                        "title" => "Hi!",
                        "body" => "This is my first Push Notification!"
                    )
                ),
                "apns" => array("aps" => array(
                    "alert" => array(
                        "title" => "Hi!",
                        "body" => "This is my first Push Notification!"
                    )
                ))
            ));
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
        return $this->respondSuccess($this->requestService->infoScore($app_id));
    }

    /**
     * @param $app_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function infoPhone()
    {
        $response = $this->requestService->infoPhone($_POST);
        return $response['status'] === true
            ? $this->respondSuccess([])
            : $this->respondError($response['message']);
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

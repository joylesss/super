<?php
namespace App\Service;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Users;
use App\Model\Apps;

class RequestService {

    /**
     * @param $app_id
     * @param $fb_id
     * @return array
     */
    public function infoApp($app_id, $fb_id)
    {
        return DB::table('apps')
            ->select('apps.name as app_name',
                'version_ios',
                'version_android',
                /*'users.id as user_id',*/
                /*'scores.id as score_id',*/
                'wins.prize',
                'wins.plan_test',
                'scores.point')
            ->leftJoin('scores', 'apps.id', '=', 'scores.app_id')
            ->leftJoin('users', function($join) use($app_id, $fb_id) {
                $join->on('scores.user_id', '=', 'users.id')
                    ->where('users.id', '=', $fb_id);
            })
            ->leftJoin('wins', 'users.id', '=', 'wins.user_id')
            ->where('apps.id', '=', $app_id)
            ->get()->toArray();
    }

    /**
     * @param $app_id
     * @return \Illuminate\Support\Collection
     */
    public function infoQuestion($app_id)
    {
        //
        return DB::table('questions')
            ->select('*')
            ->where('app_id', '=', $app_id)
            ->get();
    }

    /**
     * @param $app_id
     * @return \Illuminate\Support\Collection
     */
    public function infoScore($app_id)
    {
        return DB::table('apps')
            ->select(
                'fb_id',
                'users.name as user_name',
                'apps.name as user_app',
                'scores.point'
            )
            ->leftJoin('scores', 'apps.id', '=', 'scores.app_id')
            ->leftJoin('users', 'scores.user_id', '=', 'users.id')
            ->where('apps.id', '=', $app_id)
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    }
}

<?php
namespace App\Service;

use App\Model\Scores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Users;
use App\Model\Apps;

class RequestService {

    /**
     * @param $params
     * @return array
     */
    public function infoApp($params)
    {
        $app_id = $params['app_id'] ?? '';
        $fb_id  = $params['fb_id'] ?? '';
        if (empty($fb_id)) {
            return DB::table('apps')
                ->select('apps.name as app_name',
                    'version_ios',
                    'version_android',
                    /*'users.id as user_id',*/
                    /*'scores.id as score_id',*/
                    'apps.prize',
                    'apps.plan_test')
                ->where('apps.id', '=', $app_id)
                ->get()->toArray();
        }
        return DB::table('apps')
            ->select('apps.name as app_name',
                'version_ios',
                'version_android',
                /*'users.id as user_id',*/
                /*'scores.id as score_id',*/
                'apps.prize',
                'apps.plan_test',
                'scores.point')
            ->leftJoin('scores', 'apps.id', '=', 'scores.app_id')
            ->leftJoin('users', function($join) use($app_id, $fb_id) {
                $join->on('scores.user_id', '=', 'users.id')
                    ->where('users.id', '=', $fb_id);
            })
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
    public function infoResult($params)
    {
        $app_id = $params['app_id'] ?? '';
        $fb_id  = $params['fb_id'] ?? '';
        $score  = $params['score'] ?? '';

        $score_id = DB::table('apps')->select('scores.id as score_id')
            ->leftJoin('scores', 'apps.id', '=', 'scores.app_id')
            ->leftJoin('users', function($join) use($app_id, $fb_id) {
                $join->on('scores.user_id', '=', 'users.id')
                    ->where('users.id', '=', $fb_id);
            })
            ->where('apps.id', '=', $app_id)
            ->get()->toArray()[0]->score_id ?? '';

        $user_id = DB::table('users')->select('users.id')->where('users.fb_id', '=', $fb_id)->get()->toArray()[0]->id ?? '';

        if ($score_id) {
            $data           = Scores::findOrFail($score_id);
            $input = [
                'id'        => $score_id,
                'user_id'   => $user_id,
                'app_id'    => $app_id,
                'point'     => ($score + $data->point),
            ];
            $data->update($input);
        } else {
            $input = [
                'user_id' => $user_id,
                'app_id' => $app_id,
                'point' => $score,
            ];
            Scores::create($input);
        }
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

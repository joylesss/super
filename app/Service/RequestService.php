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

        # Case 1.
        if (empty($fb_id)) {
            $data_app = DB::table('apps')
                ->select('apps.name as app_name',
                    'version_ios',
                    'version_android',
                    'apps.prize',
                    'apps.plan_test',
                    'apps.plan_show_win')
                ->where('apps.id', '=', $app_id)
                ->get()->toArray();
            $app = [];
            if (!empty($data_app)) {
                $app = $data_app[0];
            }
            return [
                'app_name'          => $app->app_name ?? '',
                'version_ios'       => $app->version_ios ?? '',
                'version_android'   => $app->version_android ?? '',
                'prize'             => $app->prize ?? '',
                'plan_test'         => $app->plan_test ?? '',
                'plan_show_win'     => $app->plan_show_win ?? '',
            ];
        }


        $user_id    = DB::table('users')->select('users.id')->where('users.fb_id', '=', $fb_id)->get()->toArray()[0]->id ?? '';
        $data_ranks = DB::table('users')
            ->leftJoin('scores', 'users.id', '=', 'scores.user_id')
            ->select('users.id', 'users.name', 'scores.point', 'scores.user_id')
            ->where('scores.app_id', '=', $app_id)
            ->orderBy('point', 'desc')
            ->orderBy('users.created_at', 'asc')
            ->get()->toArray();
        $ranks = [];
        if (!empty($data_ranks)) {
            $data_ranks = (json_decode(json_encode($data_ranks), true));
            foreach ($data_ranks as $k => $item) {
                $ranks[$item['id']] = [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'point' => $item['point'],
                    'user_id' => $item['user_id'],
                ];
            }
        }
        $ranks = array_values($ranks);

        # Case 2: Full
        $data_score = DB::table('scores')
            ->select(
                'users.id as user_id',
                'apps.name as app_name',
                'version_ios',
                'version_android',
                'apps.prize',
                'apps.plan_test',
                'scores.point',
                'wins.prize as win_prize',
                'wins.plan_test as win_plan_test',
                'phone',
                'plan_show_win')
            ->leftJoin('users', function($join) use($fb_id) {
                $join->on('scores.user_id', '=', 'users.id')
                ->where('users.fb_id', '=', $fb_id);
            })
            ->leftJoin('apps', function($join) use($app_id) {
                $join->on('scores.app_id', '=', 'apps.id')
                    ->where('apps.id', '=', $app_id);
            })
            ->leftJoin('wins', function ($join) use ($app_id, $user_id) {
                $join->on('scores.app_id', '=', 'wins.app_id')->on('scores.user_id', '=', 'wins.user_id')
                    ->where('wins.app_id', '=', $app_id)
                    ->where('wins.user_id', '=', $user_id);
            })
            ->where('scores.app_id', '=', $app_id)
            ->where('scores.user_id', '=', $user_id)
            ->orderBy('scores.point', 'desc')
            ->get()->toArray();
        if (!empty($data_score)) {
            $score = json_decode(json_encode($data_score[0]), true);
            foreach ($ranks as $key => $item) {
                if ($item['id'] === $score['user_id']) {
                    $score['rank'] = $key+1;
                }
            }
            unset($score['user_id']);
            return [
                'app_name' => $score['app_name'] ?? '',
                'version_ios' => $score['version_ios'] ?? '',
                'version_android' => $score['version_android'] ?? '',
                'prize' => $score['prize'] ?? '',
                'plan_test' => $score['plan_test'] ?? '',
                'point' => $score['point'] ?? 0,
                'win_prize' => $score['win_prize'] ?? '',
                'win_plan_test' => $score['win_plan_test'] ?? '',
                'phone' => $score['phone'] ?? '',
                'rank' => $score['rank'] ?? 0,
                'plan_show_win' => $score['plan_show_win'] ?? '',
            ];
        }

        # Case 3: Create new user not has score point
        $data_users = DB::table('users')
            ->select('users.id as user_id', 'scores.id as score_id', 'scores.point', 'users.phone')
            ->leftJoin('scores', 'users.id', '=', 'scores.user_id')
            ->where('users.fb_id', '=', $fb_id)
            ->get()->toArray();
        $user = [];
        if (!empty($data_users)) {
            $user = $data_users[0];
        }

        $data_apps = DB::table('apps')
            ->select('apps.name', 'version_ios', 'version_android', 'apps.prize', 'apps.plan_test', 'scores.point', 'apps.plan_show_win')
            ->leftJoin('scores', 'apps.id', '=', 'scores.app_id')
            ->where('apps.id', '=', $app_id)
            ->get()->toArray();
        $app = [];
        if (!empty($data_apps)) {
            $app = $data_apps[0];
        }

        $res_win = DB::table('wins')
            ->select('wins.prize', 'wins.plan_test')
            ->leftJoin('users', function($join) {
                $join->on('wins.user_id', '=', 'users.id');
            })
            ->leftJoin('apps', function($join) {
                $join->on('wins.app_id', '=', 'apps.id');
            })
            ->where('wins.app_id', '=', $app_id)
            ->where('wins.app_id', '=', $fb_id)
            ->get()->toArray();
        $win = [];
        if (!empty($res_win)) {
            $win = $res_win[0];
        }
        return [
            'app_name'      => $app->name ?? '',
            'version_ios'   => $app->version_ios ?? '',
            'version_android' => $app->version_android ?? '',
            'prize'         => $app->prize ?? '',
            'plan_test'     => $app->plan_test ?? '',
            'point'         => !empty($user) & !empty($app) ? ($user->point === $app->point ? $user->point ?? 0 : 0) : 0,
            'win_prize'     => $win->prize ?? '',
            'win_plan_test' => $win->plan_test ?? '',
            'phone'         => $user->phone ?? '',
            'rank'          => 0,
            'plan_show_win' => $app->plan_show_win,
        ];
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
        return DB::table('scores')
            ->select('fb_id',
                'users.name as user_name',
                'apps.name as user_app',
                'scores.point')
            ->leftJoin('users', function($join) {
                $join->on('scores.user_id', '=', 'users.id');
            })
            ->leftJoin('apps', function($join) {
                $join->on('scores.app_id', '=', 'apps.id');
            })
            ->where('scores.app_id', '=', $app_id)
            ->orderBy('point', 'desc')->get();
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

        $user_id    = DB::table('users')->select('users.id')->where('users.fb_id', '=', $fb_id)->get()->toArray()[0]->id ?? '';
        $res_core   = DB::table('scores')
            ->select('scores.id as score_id')
            ->leftJoin('users', function($join) use($fb_id) {
                $join->on('scores.user_id', '=', 'users.id')
                ->where('users.fb_id', '=', $fb_id);
            })
            ->leftJoin('apps', function($join) use($app_id) {
                $join->on('scores.app_id', '=', 'apps.id')
                    ->where('apps.id', '=', $app_id);
            })
            ->where('scores.app_id', '=', $app_id)
            ->where('scores.user_id', '=', $user_id)
            ->get()->toArray();

        $score_id = '';
        if (!empty($res_core)) {
            $score_id = $res_core[0]->score_id;
        }

        if ($score_id) {
            $data           = Scores::findOrFail($score_id);
            $max_score = $data->point;
            if ($score > $data->point) {
                $max_score = $score;
            }
            $input = [
                'id'        => $score_id,
                'user_id'   => $user_id,
                'app_id'    => $app_id,
                'point'     => $max_score,
            ];
            $data->update($input);
        } else {
            $input = [
                'user_id'   => $user_id,
                'app_id'    => $app_id,
                'point'     => $score,
            ];
            Scores::create($input);
        }
    }

    public function infoPhone($params) {
        $fb_id = $params['fb_id'] ?? '';
        $phone = $params['phone'] ?? '';

        # Check FB Id
        $user_id    = DB::table('users')->select('users.id')->where('users.fb_id', '=', $fb_id)->get()->toArray()[0]->id ?? '';
        if (empty($user_id)) {
            return [
                'status' => false,
                'message' => 'FB Id information does not exist!'
            ];
        }

        if (!empty($phone)) {
            return [
                'status' => Users::findOrFail($user_id)->update(['phone' => $phone])
            ];
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

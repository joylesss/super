<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\JWTAuth;
use App\Model\Users;
use App\Service\RequestService;

class AuthController extends Controller
{

    protected $requestService;

    public function __construct(RequestService $requestService)
    {
//        $this->middleware('auth:api', ['except' => ['login']]);
        $this->requestService = $requestService;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $input = request()->all();

        $user = DB::table('users')->select('*')->where('fb_id', '=', $input['fb_id'])->get()->toArray();
        if ($user) {
            $input['id']    = $user[0]->id;
            $data           = Users::findOrFail($input['id']);
            $data->update($input);
        } else {
            $input['password'] = bcrypt('password');
            Users::create($input);
        }

        $credentials = [
            'fb_id'     => $input['fb_id'],
            'password'  => 'password',
        ];
        $token = Auth::attempt($credentials);

        return $this->respondSuccess($this->requestService->infoApp($input));

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->respondSuccess(Auth::user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token'  => $token,
            'token_type'    => 'bearer',
            'expires_in'    => auth()->factory()->getTTL() * 60
        ]);
    }
}

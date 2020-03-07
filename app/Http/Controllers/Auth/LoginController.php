<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\SocialAccounts;
use App\Users;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /*public function username()
    {
        return 'fb_email';
    }*/

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();



            $authUser = $this->findOrCreateUser($user);
            Auth::login($authUser, true);
            return redirect($this->redirectTo);

            /*Auth::login($authUser, true);
            return redirect($this->redirectTo);

            $create['name']     = $user->name;
            $create['fb_email'] = $user->email;
            $create['fb_id']    = $user->id;

            $userModel = new Users;
            $createdUser = $userModel->addNew($create);
            Auth::loginUsingId($createdUser->id);
            return redirect()->route('home');*/
        } catch (Exception $e) {
            return redirect('/');
        }
    }

    public function findOrCreateUser($user)
    {
        $authUser = SocialAccounts::where('provider', 'facebook')->first();
        if ($authUser) {
            return $authUser;
        }
        return SocialAccounts::create([
            'user_id' => 1,
            'provider_id' => $user->id,
            'provider' => 'facebook',
        ]);
    }
}

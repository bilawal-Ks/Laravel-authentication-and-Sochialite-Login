<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Socialize;

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
      // Google login
      public function redirectToGoogle()
      {
          return Socialite::driver('google')->redirect('google');
      }

      public function handleGoogleCallback()
    {
        try {
            $User = Socialite::driver('google')->user();
            $finduser = User::where('email', $User->email)->first();
            if($finduser){
       
                Auth::login($finduser);
      
                return redirect('home');
       
            }else{
                $newUser = User::create([
                    'first_name' => $User->first_name,
                    'last_name' => $User->last_name,
                    'email' => $User->email,
                    // 'google_id'=> $User->id,
                    // 'password' => encrypt('123456dummy')
                ]);
      
                Auth::login($newUser);
      
                return redirect('home');
            }
      
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
















  
      // Google callback
    //   public function handleGoogleCallback()
    //   {
    //       $user = Socialite::driver('google')->user();
  
    //       $this-> registerOrLoginUser($user);
  
    //       // Return home after login
    //       return redirect()->route('home');
    //   }

    //   protected function registerOrLoginUser($data)
    //   {
    //       $user = User::where('email', $data->email)->first();
    //       if (!$user) {
    //         $newUser = User::create([

    //             'first_name' => $data->name,

    //             'email' => $data->email,

    //             'google_id'=> $data->id

    //         ]);

    //         Auth::login($newUser);
    //       }
    //        Auth::login($user);
    //   }

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Hash;
use Auth;

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
    
    public function login(Request $request)
    {
      // dd(Hash::make('admin'));
      $input = $request->all();

      $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required',
      ]);

      if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'], 'verif'=>'login')))
      {
        // dd(Hash::make('pemilik'));
        if (auth()->user()->role == 'pemilik') {
          return redirect()->route('pemilik.home');
        }elseif (auth()->user()->role == 'admin') {
          return redirect()->route('admin.home');
        }elseif (auth()->user()->role == 'customer') {
          Auth::logout();
        }elseif (auth()->user()->role == 'anggota') {
          return redirect()->route('marketing.home');
        }elseif (auth()->user()->role == 'pemilik') {
          return redirect()->route('pemilik.index');
        }
      }else{
        return redirect()->route('login')
        ->with('error','Email-Address And Password Are Wrong.');
      }

    }
  }

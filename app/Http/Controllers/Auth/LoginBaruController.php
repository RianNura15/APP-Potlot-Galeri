<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Hash;
use DB, Response, Auth;

class LoginBaruController extends Controller
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
      $input = $request->all();

      $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required',
        'koderef_cust' => 'required',
      ]);

      $cek = DB::table('users')->where('koderef_mark', $input['koderef_cust'])->first();

      if ($cek && $input['koderef_cust'] == $cek->koderef_mark) {
        DB::table('users')->where('email', $input['email'])->update([
          'koderef_cust' => $input['koderef_cust'],
        ]);
        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'], 'verif'=>'login')))
        {
          if (auth()->user()->role == 'customer') {
            return redirect()->route('blog.index');
          }
        } else {
            return redirect()->route('login')
                ->with('error', 'Email or Password is incorrect.');
        }
      } else {
          return redirect()->route('login')
            ->with('error', 'Invalid koderef_cust.');
      }
    }
  }

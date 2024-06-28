<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class checkrole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, Closure $next)
     {

       $roles = array_slice(func_get_args(), 2);
         foreach ($roles as $role) {
           if (Auth::user()) {
             $user = \Auth::user()->role;
             if( $user == $role){
               return $next($request);
             }
           }else {
             return redirect('login');
           }
         }
         return redirect('/');
     }
}

<?php

namespace App\Http\Middleware;

use Closure;

class AuthDetail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  String $roles [<data from middleware>]
     * @return mixed
     */
    public function handle($request, Closure $next,$roles = '')
    {
        $roles = explode('|',$roles);
        $roles = \Session::get('user.roles')->filter(function($i) use($roles){
            return in_array($i,$roles) !== false;
        })->count();
        if($roles > 0){
            return $next($request);
        }else{
            return redirect(env('APP_PLATAFORMA_PRINCIPAL'));
        } 
    }
}

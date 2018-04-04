<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class AuthCustom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
 

    public function handle(Request $request, Closure $next)
    {
       
      if(!$request->is('principal') && !$request->is('/')){ 
        $util = new \App\Http\Controllers\Utilidades();
        if (\Session::get('sessionId') == null) {
          return redirect(env('APP_PLATAFORMA_PRINCIPAL'));
        }
        $parametros = [ 
            'security' => ['sessionId'=>\Session::get('sessionId')],
            'data' => [
              'origen'=> 'Comsoc'
            ]
        ];
       
        $json = $util->muleConnection('POST','/helpdesk/linked',9003,$parametros);
        if(!is_null($json) && $json['error']['code']==0){
          return $next($request);
        }else{
          return \Redirect::to(env('APP_PLATAFORMA','http://www.desarrollosistemas.cdmx.gob.mx'));    
        }
      }else{
        return $next($request);
      } 
    }
}

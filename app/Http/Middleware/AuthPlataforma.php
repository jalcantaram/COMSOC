<?php

namespace App\Http\Middleware;

use Closure;

class AuthPlataforma
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
        \Session::flush();
        if(!\Session::has('sessionId')){
            if(isset($request->sess)){
                $pattern = '/^[a-f0-9]{24}$/';
                 
                if(preg_match($pattern,$request->sess)==1){ 
                    $util = new \App\Http\Controllers\Utilidades();
                    $parametros = [ 
                        'security' => ['sessionId'=>$request->sess],
                        'data' => [
                          'origen'=> 'Comsoc'
                        ]
                    ]; 

                    $json = $util->muleConnection('POST','/helpdesk/linked',9003,$parametros);
                    
                    if($json['error']['code']==0){
                        if(!empty($json['data']['roles'])){ 

                            \Session::put('sessionId',$request->sess);
                            \Session::put('cdmxId',$json['data']['cdmxId']);
                            \Session::put('citizenId',$json['data']['citizen_id']);
                            \Session::put('curp',$json['data']['CURP']);
                            \Session::put('nombres',$json['data']['nombres']);
                            \Session::put('paterno',$json['data']['paterno']);
                            \Session::put('materno',$json['data']['materno']);
                            \Session::put('sessionStart',date('Y-m-d'));  

                            \Session::put('user.roles', collect($json['data']['roles'])->map(function($i,$k){
                                return $i['role'];
                            }));
                            
                            return $next($request);
                        }else{
                            return \Redirect::to(env('APP_PLATAFORMA','http://www.desarrollosistemas.cdmx.gob.mx'));
                        }
                    }else{
                        return \Redirect::to(env('APP_PLATAFORMA','http://www.desarrollosistemas.cdmx.gob.mx'));    
                    }
                }else{ 
                    return \Redirect::to(env('APP_PLATAFORMA','http://www.desarrollosistemas.cdmx.gob.mx')); 
                }

            }else{
                return \Redirect::to(env('APP_PLATAFORMA','http://www.desarrollosistemas.cdmx.gob.mx'));
            }
        }else{
            return $next($request);    
        }
    }
}

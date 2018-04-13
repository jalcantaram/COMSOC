<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Http\Response;
use Redirect;

class fsvte extends Controller{
    
  // public function obtieneDatosEnlazados(Request $request){
  //     \Session::reflash();
  //     $data = \App\StaticContent::obtieneDefinicionFSVTE();
  //     $variable = $request->v;
  //     if(collect($data)->filter(function($i) use($variable){ return isset($i['bind']) && $i['bind'] == $variable; })->count()){
  //         $parametros['data'] = $data[$request->v]['src']['parameters'];
  //         $src = $data[$request->v]['src'];
  //         $parametros['data']['valores']['eje'] = $request->i;
        
  //         $util = new Utilidades();
  //         $retorno = $util->muleConnection($src['type'],$src['method'],$src['port'],$parametros);
  //         return $retorno['data'][0][$src['campo']];
  //     }
  // }

  private $util;
  private $uploader;

  function __construct(){
    $this->util = new Utilidades();
    $this->uploader = new Uploader();
  }

  private function getFile($url, $base64 = true){
    // $uploader  = $this->;
    $respuesta = $this->uploader->obtieneArchivo($url);

    if($respuesta['error']['code'] == 0){
      if($base64){
        $file = $respuesta['data'];
      }else{
        $file = base64_decode($respuesta['data']);
      }
      
    }else{
      if($base64){
        $file = base64_encode(\PDF::loadHTML(\View::make('errors.pdfNotFound'))->setWarnings(false)->stream());
      }else{
        $file = \PDF::loadHTML(\View::make('errors.pdfNotFound'))->setWarnings(false)->stream();
      }
      
    }
    return $file; 
  }

  public function obtieneFichas(){
    $util = new Utilidades();
    $retorno = $util->muleConnection('GET','/comsoc/schemaExpediente/all?sessionId='.\Session::get('sessionId'), 10017);
    if($retorno['error']['code']==0){
      if (\Session::get('user.roles')->contains('Comsoc_operativo')) {
       return $retorno['data'] = collect($retorno['data'])->filter(function($v, $k){
          return $v['status'] == 'captura' || $v['status'] == 'firmaTitular' || $v['status'] == 'firmaDGA';
       }); 
      }elseif (\Session::get('user.roles')->contains('Viatinet_Titular') || (\Session::get('user.roles')->contains('Viatinet_supTitular'))) {
        return $retorno['data'] = collect($retorno['data'])->filter(function($v, $k){
          return $v['status'] == 'firmaTitular' || $v['status'] == 'firmaDGA';
        });
      }elseif (\Session::get('user.roles')->contains('Viatinet_Dga') || (\Session::get('user.roles')->contains('Viatinet_supDga'))) {
        return $retorno['data'] = collect($retorno['data'])->filter(function($v, $k){
          return $v['status'] == 'firmaDGA';
        });
      }
    }else{
      return $retorno['error']['msg'];
    }      
  }

  // public function obtieneFichasRechazadas(){
  //   \Session::reflash();    
  //   $util = new Utilidades();
  //   $retorno = $util->muleConnection('GET','/viaticos/schemaViaticos/all?token='.\Session::get('sessionId'), 10010);
  //   if($retorno['error']['code']==0){
  //     if (\Session::get('user.roles')->contains('Viatinet_Operativo')) {
  //      return $retorno['data'] = collect($retorno['data'])->filter(function($v, $k){
  //         return $v['status'] == 'rechazadoTitular' || $v['status'] == 'rechazadoDGA';
  //      }); 
  //     }elseif (\Session::get('user.roles')->contains('Viatinet_Titular') || (\Session::get('user.roles')->contains('Viatinet_supTitular'))) {
  //       return $retorno['data'] = collect($retorno['data'])->filter(function($v, $k){
  //         return $v['status'] == 'rechazadoTitular' || $v['status'] == 'rechazadoDGA';
  //       });
  //     }elseif (\Session::get('user.roles')->contains('Viatinet_Dga') || (\Session::get('user.roles')->contains('Viatinet_supDga'))) {
  //       return $retorno['data'] = collect($retorno['data'])->filter(function($v, $k){
  //         return $v['status'] == 'rechazadoDGA';
  //       });
  //     }
  //   }else{
  //     return $retorno['error']['msg'];
  //   }      
  // }

  // public function obtieneFichasAutorizadas(){
  //   $util = new Utilidades();
  //   $retorno = $util->muleConnection('GET','/viaticos/schemaViaticos/all?token='.\Session::get('sessionId'), 10010);
  //   if($retorno['error']['code']==0){
  //    return $retorno['data'] = collect($retorno['data'])->filter(function($v, $k){
  //       return $v['status'] == 'Autorizado';
  //    }); 
  //   }else{
  //     return $retorno['error']['msg'];
  //   }      
  // }

  // public function getDetail(Request $request){
  //   \Session::reflash();
  //   \Session::forget('_id');
  //   \Session::forget('created');
  //   \Session::forget('fase');
  //   \Session::forget('faseActualDatos');
  //   $util = new Utilidades();
  //   $viatico = $request['f'];
  //   $session = $request['sess'];
  //   $json = $util->muleConnection('GET','/viaticos/schemaViaticos?token='.$session.'&viatico='.$viatico, 10010);
  //    if($json['error']['code']==0){
  //       \Session::put('_id',$json['data']['_id']);
  //       \Session::put('created',$json['data']['created']);
  //       unset($json['data']['created']); 
  //       unset($json['data']['fase']);
  //       unset($json['data']['cdmxIdCreated']);
  //       unset($json['data']['activo']);
  //       foreach($json['data'] as $fase=>$data){
  //         \Session::put('fase.'.$fase,$data);
  //       }
  //       \Session::put('faseActual',$fase);
  //       $datos = $json;
  //       return view('fsvte.info', compact('datos'));
  //   }else{
  //       return redirect('/svte');
  //   }
  // }

  public function getSecuencia(Request $request){
    if ($request->ajax()){
      $util = new Utilidades();
      $json = $util->muleConnection('GET','/comsoc/getSecuenciaAnio?sessionId='.\Session::get('sessionId').'&anio='.(string)$request->anio, 10017,false);
      return response()->json($json['data']);  
    }
  }

  public function creaFicha(Request $request){
    $input = $request->input();
    $util = new Utilidades();
    $typeName = $input['tipo'];
    $res = [];
    foreach ($typeName as $key => $value) {
      list($k, $v) = explode('|', $value);
      $res[$k] = $v;
    }
    $parametros = [
      'security'=>[
        'sessionId' => \Session::get('sessionId')
      ],
      'data'=>[
        'anio' => (int)$input['year'],
        $this->generaFases()['sidebar']['datosEmpresa']['id'] => [
          'bloquedo' => false,
          'vacio' => true,
        ],
        'type' => $res
      ]
    ];
    $json = $util->muleConnection('POST','/comsoc/saveSchemaExpediente', 10017,$parametros);
    if($json['error']['code']==0){
      \Session::put('idExpediente',$json['data']['idExpediente']);
      \Session::put('created',$json['data']['created']);
      foreach($json['data'] as $fase => $data){
        \Session::put('fase.'.$fase, $data);
      }
      \Session::put('faseActual','datosEmpresa');
      \Session::put('faseActualDatos','fase.datosEmpresa');
      $parametros  = $this->generaFases() + $this->generaDefinicion();
      \Session::put('urlBack', '/svte');        
      return redirect('/efsvte?f='.$json['data']['idExpediente']);
    }else{
      $retorno = json_encode(['color'=>'#C6383D',
        'error'=>$json['error']['code'],
        'msg'=>$json['error']['msg']
      ]);
      return redirect('/svte')->with($retorno);          
    }     
  }

  public function editaFicha(Request $request){
    \Session::reflash();
    \Session::forget('fase');
    \Session::forget('faseActual');
    \Session::forget('faseActualDatos');
    $input = $request->input();
    $util = new Utilidades();
    $expediente = $request['f'];
    $json = $util->muleConnection('GET','/comsoc/schemaExpediente?sessionId='.\Session::get('sessionId').'&idExpediente='.$expediente, 10017);
    if($json['error']['code']==0){
      \Session::put('urlBack', \URL::previous());
      \Session::put('idExpediente',$json['data']['_id']);
      \Session::put('created',$json['data']['created']);
      foreach($json['data'] as $fase=>$data){
        \Session::put('fase.'.$fase,$data);
      }
      \Session::put('faseActual','datosEmpresa');
      \Session::put('faseActualDatos','fase.datosEmpresa');
      $parametros  = $this->generaFases() + $this->generaDefinicion();
      return \View::make('fsvte.fichaSVTE')->with($parametros);
    }else{
        return redirect('/svte');
    }
  }

  public function guardaFicha(Request $request){
    $input = $request->input();
    unset($input['_token']);
    $validacion = $this->validaFase($input);
    if($validacion['valido']){
      $util = new Utilidades();
      $faseArray = $this->generaFases()['sidebar'][\Session::get('faseActual')]['array'];
      if($faseArray){ 
        $input = [$input]; 
      }
      // dd(\Session::all());
      // dd(array_keys($input));
      // if (count($input['documents']) != 0) {
        $input['vacio'] = false;
        $input['bloqueado'] = true;
        $parametros = [
          'security' => [
            'sessionId' => \Session::get('sessionId')
          ],
          'data'=>[
            'idExpediente' => \Session::get('idExpediente'),
            'modified' => [
              \Session::get('faseActual') => $input 
            ]
          ]
        ];
      // }else{
      //   $retorno = json_encode(['color'=>'#C6383D',
      //     'error'=> 99,
      //     'msg'=> 'Debe ingresar un documento'
      //   ]);
      //   return $retorno;
      // }

      $arrayDocs = array_filter($input,function($a){ return is_array($a); });
      $confirmFile = [];
      foreach ($arrayDocs as $key => $cont) { 
        foreach($parametros['data']['modified'][\Session::get('faseActual')][$key] as $data){
          if($data['code'] == null && $data['filePath'] == null && $data['status'] == null){
            $confirmFile[] = $this->uploader->confirmarArchivo($data['url']);
          }
        }
        for ($y=0; $y < count($confirmFile); $y++) { 
          for ($x=0; $x < count($parametros['data']['modified'][\Session::get('faseActual')][$key]); $x++) {
            if($confirmFile[$y]['data']['source'] === $parametros['data']['modified'][\Session::get('faseActual')][$key][$x]['url']){
              $parametros['data']['modified'][\Session::get('faseActual')][$key][$x]['code'] = $confirmFile[$y]['error']['code'];
              if($confirmFile[$y]['error']['code'] == 0){
                $parametros['data']['modified'][\Session::get('faseActual')][$key][$x]['filePath'] = $confirmFile[$y]['data']['filePath']; 
                $parametros['data']['modified'][\Session::get('faseActual')][$key][$x]['code'] = $confirmFile[$y]['error']['code'];
                $parametros['data']['modified'][\Session::get('faseActual')][$key][$x]['status'] = true;
                $parametros['data']['modified'][\Session::get('faseActual')][$key][$x]['url'] = null;
              }else{
                $parametros['data']['modified'][\Session::get('faseActual')][$key][$x]['filePath'] = null; 
                $parametros['data']['modified'][\Session::get('faseActual')][$key][$x]['status'] = false;
                $parametros['data']['modified'][\Session::get('faseActual')][$key][$x]['url'] = null;
              }
            }
          }
        }
      }

    //   dd($parametros);
      
      $json = $util->muleConnection('PUT','/comsoc/schemaExpediente',10017,$parametros);
      if($json['error']['code']==0){
        \Session::forget('fase.'.\Session::get('faseActual'));
        \Session::put('fase.'.\Session::get('faseActual'),$json['data'][\Session::get('faseActual')]);
        $retorno = json_encode(['color'=>'blue',
          'error'=>$json['error']['code'],
          'msg'=>$json['error']['msg'],
          'fase'=>\Session::get('faseActual')
        ]);
        if($faseArray){
          \Session::forget('faseStatus.'.\Session::get('faseActual'));
          \Session::put('faseStatus.'.\Session::get('faseActual'),'table');
          \Session::forget('faseArrayEdit');
        }
      }else{
        $retorno = json_encode(['color'=>'#C6383D',
          'error'=>$json['error']['code'],
          'msg'=>$json['error']['msg']
        ]);
      }      
    }else{
      $retorno = json_encode(['color'=>'#C6383D',
        'error' => 99,
        'msg' => 'Hay campos con errores',
        'validacion' => $validacion['validacion']
      ]); 
    }
    return $retorno;
  }

  public function getFilebyPath(Request $request){
    $file = $this->getFile($request->file,false);
    $fileInfo = pathinfo($request->file);
    return \Response::make($file,'200',array(
      'Content-Type'=>'application/pdf'
    ));
  }

  // public function finRegistro(Request $request){
  //   $util = new Utilidades();
  //   $viatico = \Session::get('_id');
  //   if ($request->ajax()) {
  //     if (count(\Session::get('fase.'.\Session::get('faseActual').'.comisionados')) == 0) {
  //       $retorno = json_encode(['color'=>'#C6383D',
  //         'error'=>99,
  //         'msg'=>'Debe existir minimo un comisionado'
  //       ]);
  //     }else{
  //       if (\Session::get('fase.detalleComision.vacio') != true) {
  //         $obsTitular = $request->input('observacionesTitular')?$request->input('observacionesTitular'):null;
  //         $obsDGA = $request->input('observacionesDGA')?$request->input('observacionesDGA'):null;
  //         $collectReq = array('observacionesTitular' => $obsTitular, 'observacionesDGA' => $obsDGA);
  //         $comisionados = \Session::get('fase.'.\Session::get('faseActual').'.comisionados');
  //         $sum = 0;
  //         foreach ($comisionados as $key => $item) {
  //           foreach ($item['pasajes'] as $pkey => $pitem) {
  //             settype($pitem['montoPasajes'], "double");
  //             $sum += $pitem['montoPasajes'];
  //           }
  //           foreach ($item['viaticos'] as $vkey => $vitem) {
  //             settype($vitem['montoViaticos'], "double");
  //             $sum += $vitem['montoViaticos']; 
  //           }
  //         }            
  //         $parametros = [
  //           'security' => [
  //             'sessionId'=>\Session::get('sessionId')
  //           ],
  //           'data' =>[
  //             'idViatico'=>\Session::get('_id'),
  //             'fase'=>\Session::get('faseActual'),
  //             'modified'=>[
  //               \Session::get('faseActual') => [
  //                 'numComisionados' => count($comisionados),
  //                 'montoTotal' => $sum
  //               ]
  //             ]
  //           ]            
  //         ];
  //         collect($collectReq)->filter(function($v, $k){
  //           return $v != null;
  //         })->each(function($v, $k) use(&$parametros){
  //           $parametros['data']['modified'][\Session::get('faseActual')][$k] = $v;
  //         });
  //         // dd(json_encode($parametros));
  //         $json = $util->muleConnection('PUT', '/viaticos/schemaViaticos?token='.\Session::get('sessionId'), 10010, $parametros);
  //         if ($json['error']['code'] == 0) {           
  //           $respuesta = $util->muleConnection('GET','/viaticos/statusFwd?token='.\Session::get('sessionId').'&viatico='.$viatico,10010);
  //           if($respuesta['error']['code']==0){
  //             $retorno = json_encode(['color'=>'blue',
  //               'error'=>$respuesta['error']['code'],
  //               'msg'=>$respuesta['error']['msg']
  //             ]);
  //           }else{
  //             $retorno = json_encode(['color'=>'#C6383D',
  //               'error'=>$respuesta['error']['code'],
  //               'msg'=>$respuesta['error']['msg']
  //             ]);
  //           }
  //         }else{
  //           $retorno = json_encode([
  //             'color' => '#C6383D',
  //             'error' => $json['error']['code'],
  //             'msg' => $json['error']['msg']
  //           ]);
  //         }
  //       }else{
  //         $retorno = json_encode(['color'=>'#C6383D',
  //           'error'=>99,
  //           'msg'=>'Debe llenar la fase anterior'
  //         ]);
  //       }
  //     }
  //     return $retorno;   
  //   }
  // }

  // public function getEstados(Request $request){
  //   if ($request->ajax()) {
  //     $util = new Utilidades();
  //     $json = $util->muleConnection('GET','/viaticos/catalogos/lugares?continente=América&pais=MEX',10010,false);
  //     $collection = collect($json['data']['estado']);
  //     $estado = $collection->map(function ($item, $key) {
  //       return [$key, $item['claveEstado'], $item['nombreEstado']];
  //     });
  //     return response()->json($estado->all());      
  //   }
  // }

  // public function getMunicipio(Request $request){
  //   $municipio = $request->input('municipio');
  //   if ($request->ajax()) {
  //     $util = new Utilidades();
  //     $json = $util->muleConnection('GET','/viaticos/catalogos/lugares?continente=América&pais=MEX&edo='.$municipio,10010,false);
  //     return response()->json($json['data']);
  //   }
  // }

  // public function getContinente(Request $request){
  //   if ($request->input('continente') == 'África') {
  //     $afr = $request->input('continente');
  //     $afr = '%C3%81frica'; 
  //    if ($request->ajax()) {
  //       $util = new Utilidades();
  //       $json = $util->muleConnection('GET','/viaticos/catalogos/lugares?continente='.$afr,10010,false);
  //       $collection = collect($json['data']);
  //       $estado = $collection->map(function ($item, $key) {
  //         return [$key, $item['clavePais'], $item['nombrePais']];
  //       });
  //       return response()->json($estado->all());
  //     }
  //   }else{
  //     if ($request->ajax()) {
  //       $util = new Utilidades();
  //       $json = $util->muleConnection('GET','/viaticos/catalogos/lugares?continente='.$request->input('continente'),10010,false);
  //       $collection = collect($json['data']);
  //       $estado = $collection->map(function ($item, $key) {
  //         return [$key, $item['clavePais'], $item['nombrePais']];
  //       });
  //       return response()->json($estado->all());
  //     }  
  //   }
  // }

  // public function getPaisInternacional(Request $request){
  //   $pais = $request->input('pais');
  //   if ($request->input('continente') == 'África') {
  //     $afr = $request->input('continente');
  //     $afr = '%C3%81frica'; 
  //    if ($request->ajax()) {
  //       $util = new Utilidades();
  //       $json = $util->muleConnection('GET','/viaticos/catalogos/lugares?continente='.$afr.'&pais='.$pais,10010,false);
  //       $collection = collect($json['data']['estado']);
  //       $estado = $collection->map(function ($item, $key) {
  //         return [$key, $item['nombreEstado']];
  //       });
  //       return response()->json($estado->all());
  //     }
  //   }else{
  //     if ($request->ajax()) {
  //       $util = new Utilidades();
  //       $json = $util->muleConnection('GET','/viaticos/catalogos/lugares?continente='.$request->input('continente').'&pais='.$pais,10010,false);
  //       $collection = collect($json['data']['estado']);
  //       $estado = $collection->map(function ($item, $key) {
  //         return [$key, $item['nombreEstado']];
  //       });
  //       return response()->json($estado->all());
  //     }  
  //   }
  // }

  public function validaFase(&$fase){
    $valido = true;
    // dd(\App\StaticContent::obtieneDefinicionFSVTE());
    $retorno = collect(\App\StaticContent::obtieneDefinicionFSVTE())->map(function($i,$k) use(&$fase,&$valido){
      if($i['tipo'] == 'container'){
        if($i['unico']){
          if(!isset($i['tabla'])){ 
              foreach($i['detalle'] as $id=>$detalle){ 
                if($detalle['tipo'] == 'modal'){
                  if($fase[$k][$id] == ''){
                      $code[$id] = 'Error';
                  }else{ 
                      $itemDetalles = json_decode(base64_decode($fase[$k][$id]),true);
                      $search = ['https://','https:/','https:','https','http://','http:/','http:','http'];
                      $replace = ['__#s:__','__#s:__','__#s:__','__#s:__','__#:__','__#:__','__#:__','__#:__'];
                      foreach($itemDetalles as $iKey=>$iDetalles){
                          //dd($iKey);
                          if($detalle['detalle'][$iKey]['tipo']=='url'){ //dd($iDetalles);
                              $iDetalles = str_replace($search,$replace,$iDetalles);
                              if(strpos($iDetalles,'__#s:__') === false && strpos($iDetalles,'__#:__') === false){
                                  $iDetalles = 'http://'.$iDetalles;
                              }else{
                                  $iDetalles = str_replace('__#s:__','https://',$iDetalles);
                                  $iDetalles = str_replace('__#:__','http://',$iDetalles);
                              }
                              $itemDetalles[$iKey] = $iDetalles;
                          }
                      }
                      $fase[$k][$id] = $itemDetalles;
                      $code[$id] = 0;
                  }
                }else{ 
                  $code[$id] = $this->validaTipo($fase[$k],$valido,$id,$detalle);
                } 
                if(isset($detalle['objectContainer'])){ 
                  $auxiliar = $fase[$k][$id]; 
                  unset($fase[$k][$id]); 
                  $fase[$k][$detalle['objectContainer']][$id]=$auxiliar;
                }    
              }
          }else{
              foreach($i['filas'] as $idFila=>$fila){
                foreach($i['detalle'] as $id=>$detalle){
                  $code[$idFila][$id] = $this->validaTipo($fase[$k][$idFila],$valido,$id,$detalle);
                }
              }
          }
        }else{
          foreach($fase[$k] as $idMult=>$faseMult){
            foreach($i['detalle'] as $id=>$detalle){
              if(isset($detalle['requiereSumar']) && !isset($aux) ){ 
                  \Session::put($detalle['requiereSumar'],0);
                  $aux = $detalle['requiereSumar'];
              }
              if($detalle['tipo'] == 'modal'){
                  if($fase[$k][$idMult][$id] == ''){
                      //$valido = false;
                      $code[$idMult][$id] = 'Error 1';
                  }else{
                      $itemDetalles = json_decode(base64_decode($fase[$k][$idMult][$id]),true);
                      $search = ['https://','https:/','https:','https','http://','http:/','http:','http'];
                      $replace = ['__#s:__','__#s:__','__#s:__','__#s:__','__#:__','__#:__','__#:__','__#:__'];
                      foreach($itemDetalles as $iKey=>$iDetalles){
                          //dd($iKey);
                          if($detalle['detalle'][$iKey]['tipo']=='url'){ //dd($iDetalles);
                              $iDetalles = str_replace($search,$replace,$iDetalles);
                              if(strpos($iDetalles,'__#s:__') === false && strpos($iDetalles,'__#:__') === false){
                                  $iDetalles = 'http://'.$iDetalles;
                              }else{
                                  $iDetalles = str_replace('__#s:__','https://',$iDetalles);
                                  $iDetalles = str_replace('__#:__','http://',$iDetalles);
                              }
                              $itemDetalles[$iKey] = $iDetalles;
                          }
                      }
                      $fase[$k][$idMult][$id] = $itemDetalles;
                      $code[$idMult][$id] = 0;
                  }
              }else{
                if($detalle['tipo'] == 'index'){
                  $fase[$k][$idMult][$id] = $idMult;
                  $code[$idMult][$id] = 0;
                }else{
                  $code[$idMult][$id] = $this->validaTipo($faseMult,$valido,$id,$detalle);
                  if(isset($detalle['objectContainer'])){
                    $fase[$k][$idMult][$detalle['objectContainer']][$id]=$fase[$k][$idMult][$id];
                    unset($fase[$k][$idMult][$id]);
                  }
                }   
              }     
            }
          } 
          if(isset($aux)){
            \Session::forget($aux);  
          }    
        }
        if(isset($i['objectContainer'])){
          $auxiliar = $fase[$k];
          unset($fase[$k]);
          $fase[$k][$i['objectContainer']] = $auxiliar;
        } 
      }else{
        if($i['tipo'] == 'upload'){
            $code = 0;
            if(!isset($fase[$k]) && !\Session::has('fase.'.\Session::get('faseActual').'.'.$k) &&  empty(\Session::get('fase.'.\Session::get('faseActual').'.'.$k))){
              $fase[$k] = [];
            }else{ 
                if(!isset($fase[$k])) $fase[$k] = [];
                if(!empty(\Session::get('fase.'.\Session::get('faseActual').'.'.$k))){
                  // foreach(\Session::get('fase.'.\Session::get('faseActual').'.documents') as $documento){
                      // $documentos[$documento['id']] = $documento;
                      // $i=$documento['id']+1;
                  // }
                  $i=0;
                  $documentos = [];
                }else{
                  $i=0;
                  $documentos = [];
                }
                // dd($fase[$k]);
                foreach($fase[$k] as $documento){
                //   dd($documento);
                  if(trim($documento['nombreDocumento']) == ''){ $code = 'Todos los archivos deben tener título'; $valido = false; }
                  $documentos[$i] = [
                    'originalName' => $documento['nombreDocumento'],
                    'url' => isset($documento['url']) ? $documento['url'] : null ,
                    'filePath' => isset($documento['filePath']) ? $documento['filePath'] : null,
                    'code' => isset($documento['code']) ? (int)$documento['code'] : null,
                    'status' => isset($documento['status']) ? (bool)$documento['status'] : null
                  ];
                  $i++;
                }
                $fase[$k] = $documentos;
                // dd($fase['documents']);
            }
        }else{
            if($i['tipo'] == 'null'){
                $code = 0;
                $fase[$k]=null;
            }else{
                if(isset($i['multi'])){
                    $fase[$k] = implode($i['multi']['separador'],$fase[$k]);
                }
                $code = $this->validaTipo($fase,$valido,$k,$i);
                if(isset($i['objectContainer'])){
                    $fase[$i['objectContainer']][$k]=$fase[$k];
                    unset($fase[$k]);
                }
                if(isset($i['arrayContainer'])){
                    $fase[$k] = [$fase[$k]];
                }
                if(isset($i['action'])){
                    switch($i['action']){
                        case 'count':
                            $posicion = explode('.',$i['src']['variable']);
                            unset($posicion[0]);
                            unset($posicion[1]);
                            $dataAction = $fase;
                            foreach($posicion as $pos){
                                $dataAction = $dataAction[$pos];
                            }
                            $fase[$k]=count($dataAction);
                            break;
                    }
                }
            }
        }  
      }
      return $code;
    });
    return ['validacion'=>$retorno,'valido'=>$valido];
  }

  public function validaTipo(&$fase,&$valido,$k,$i){
    $code = 0;
    // dd([$i['tipo'], $fase[$k], $fase, !isset($fase[$k])]);
    if(isset($i['requiereAlmacenar'])) \Session::put($i['requiereAlmacenar'],$fase[$k]); 
    if($i['tipo']!='label'){
      if(!isset($fase[$k]) && $i['tipo'] != 'boolean' && $fase[$k] != ''){
        $valido = false;
        $code = 'Campo ilegible';
      }else{
        // dd($i);
        if($i['tipo'] == 'boolean' && isset($fase[$k])) $fase[$k] = true;
        if($i['tipo'] == 'boolean' && !isset($fase[$k])) $fase[$k] = false; 
        if($i['requerido'] && $fase[$k] == trim('')){
            $valido = false;
            $code = 'El campo es requerido';
        }else{
          // dd(($fase[$k]!=trim('') && !isset($i['action'])));
          if($fase[$k]!=trim('') && !isset($i['action'])){
              // dd($i['tipo']);
              switch($i['tipo']){
                  case 'url': 
                      if(strpos($fase[$k],'http://') === false && strpos($fase[$k],'https://') === false){
                          $code = 'La dirección URL debe contener el prefijo http:// o https://';
                          $valido = false;
                      }
                      break;
                  case 'upload': break;
                  case 'index': break;
                  case 'integer':
                  case 'unsigned':
                      $fase[$k] = (int)$fase[$k];
                      break;
                  case 'double':
                  case 'float':
                  case 'real':
                      $fase[$k] = (double)$fase[$k];
                      break;
                  case 'cp':
                      $fase[$k] = (string)$fase[$k];
                      if(strlen($fase[$k])==4){ 
                          $fase[$k] = '0'.$fase[$k];
                      }else{
                          if(strlen($fase[$k])!= 5){
                              $code = 'Código postal mal asignado';
                              $valido = false;
                          }
                      }
                      break;
                  case 'string':
                      if(isset($i['uppercase'])){
                          $fase[$k] = strtoupper((string)$fase[$k]);
                      }else{
                          $fase[$k] = (string)$fase[$k];
                      }
                      if(strlen($fase[$k])>$i['long']){
                          $code = 'El campo no puede exceder los '.$i['long'].' caracteres';
                          $valido = false;
                      }
                      if(isset($i['minLong']) && strlen($fase[$k])<$i['minLong']){
                          $code = 'El campo no puede tener menos de '.$i['minLong'].' caracteres';
                          $valido = false;
                      }
                      break;
                  case 'textarea':
                      if(isset($i['uppercase'])){
                          $fase[$k] = (string)$fase[$k];
                      }else{
                          $fase[$k] = (string)$fase[$k];
                      }
                      if(strlen($fase[$k])>$i['long']){
                          $code = 'El campo no puede exceder los '.$i['long'].' caracteres';
                          $valido = false;
                      }
                      if(isset($i['minLong']) && strlen($fase[$k])<$i['minLong']){
                          $code = 'El campo no puede tener menos de '.$i['minLong'].' caracteres';
                          $valido = false;
                      }
                      break;
                  case 'date':
                      if(!preg_match("/^[0-9]{2}\-[0-9]{2}\-[0-9]{4}$/",$fase[$k])){
                          $code = 'La fecha es incorrecta';
                          $valido = false;
                      }else{
                          list($dia,$mes,$ann) = explode('-',$fase[$k]);
                          if(!checkdate($mes, $dia, $ann)){
                              $code = 'La fecha es incorrecta';
                              $valido=false;
                          }else{
                              if(isset($i['requiereValidar'])){
                                  list($dia,$mes,$ann) = explode('-',\Session::get($i['requiereValidar']));
                                  if(!checkdate($mes, $dia, $ann)){
                                      $code = 'La fecha es incorrecta';
                                      $valido=false;
                                  }else{ 
                                      if(strtotime(date_format(date_create_from_format('d-m-Y',\Session::get($i['requiereValidar'])),'Y-m-d')) >
                                         strtotime(date_format(date_create_from_format('d-m-Y',$fase[$k]),'Y-m-d'))){
                                          $code = 'La fecha es incorrecta';
                                          $valido=false;
                                      }
                                  }
                              }
                          }
                      }

                      if(isset($i['format'])){
                          $fase[$k]=date_format(date_create_from_format('d-m-Y',$fase[$k]),$i['format']);
                      }
                      break;
                  case 'datetime':
                      if(!preg_match("/^[0-9]{2}\-[0-9]{2}\-[0-9]{4} [0-5]{1}[0-9]{1}\:[0-5]{1}[0-9]{1}\:[0-5]{1}[0-9]{1}$/",$fase[$k])){
                          $code = 'La fecha es incorrecta';
                          $valido = false;
                      }else{
                          $dia = explode(' ',$fase[$k]);
                          list($dia,$mes,$ann) = explode('-',$dia[0]);
                          if(!checkdate($mes, $dia, $ann)){
                                  $code = 'La fecha es incorrecta';
                                  $valido=false;
                          }
                      }

                      if(isset($i['format'])){
                          $fase[$k]=date_format(date_create_from_format('d-m-Y H:i:s',$fase[$k]),$i['format']);
                      }
                      break;
                  case 'time':
                      if(!preg_match("/^[0-5]{1}[0-9]{1}\:[0-5]{1}[0-9]{1}\:[0-5]{1}[0-9]{1}$/",$fase[$k])){
                          $code = 'La hora es incorrecta';
                          $valido = false;
                      }
                      break;
                  case 'select': 
                      if($fase[$k] == "0"){
                          $code = 'Debes de seleccionar una opción';
                          $valido = false;
                      }
                      break;
                  case 'pct':
                      $fase[$k] = (int)$fase[$k];
                      if($fase[$k] > 100 || $fase[$k] < 0){
                          $code = 'El porcentaje no puede exceder del 100%';
                          $valido = false;
                      }

                      if (\Session::has($i['requiereSumar'])) {
                          $reqSumar=\Session::get($i['requiereSumar']);
                          $cont=$reqSumar+$fase[$k];
                          \Session::put($i['requiereSumar'],$cont);
                          if ($cont>100) {
                              $resta=$cont-100;
                              $code = 'Te has excedido del 100% < '.(string) $resta.'%';
                              $valido = false;
                          }
                          else {
                              $resta=100-$cont;
                              $code = 'Te falta para el 100% > '.(string) $resta.'%';
                              $valido = false;
                              if ($resta==0) {
                                  $valido = true;
                                  $code =0;
                              }
                          }
                          
                      }
                                                      
                      break;
                  case 'mail':
                      if(!preg_match("/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/",$fase[$k])){
                          $code = 'La dirección de correo es inválida';
                          $valido = false;
                      }
                      break;
                  case 'mailInstitucional':
                      $subdominios = ['','finanzas.','ssp.'];
                      $pattern = "/^[_a-z0-9-]+(.[_a-z0-9-]+)*@(".implode('|',$subdominios).")(cdmx|df)(.gob.mx)$/";
                      if(!preg_match($pattern,$fase[$k])){
                          $code = 'La dirección de correo es inválida';
                          $valido = false;
                      }
                      break;
                  case 'rfc':
                    $fase[$k] = strtoupper((string)$fase[$k]);
                    if(strlen($fase[$k]) < 12 || strlen($fase[$k]) > 13){
                      $code = 'El RFC es incorrecto';
                      $valido = false;
                    }
                    break;
              }
          }
        }
      }
    }
    if(isset($i['requiereValidar'])) \Session::forget($i['requiereValidar']);
    return $code;
  }

  public function existeFase($fase){
      return \App\StaticContent::existeFase($fase);
  }

  public function generaFases(){
      return ['sidebar'=> \App\StaticContent::obtieneFasesFSVTE(\Session::get('faseActual'))];
  }

  public function generaDefinicion(){
      return ['definicion'=> \App\StaticContent::obtieneDefinicionFSVTE()];
  }

  public function generaDefinicionv2(){
      return ['definicion'=> \App\StaticContent::obtieneDefinicionFSVTEv2()];
  }

  public function nuevoItem(Request $request){
      \Session::reflash(); 
      $detalles = \App\StaticContent::obtieneDetalleFSVTE(\Session::get('faseActual'),$request->id);
      $item = '<tr>';
      foreach($detalles as $key=>$detalle){
          if($detalle['tipo'] != 'index'){
              
              switch($detalle['tipo']){
                  case 'textarea':
                      $item .= '<td>';
                      $item .= '<textarea class="form-control"
                                          name="'.$request->id.'['.$request->position.']['.$key.']"></textarea>';
                      break;
                  case 'select':
                      $item .= '<td>';
                      $item .= '<select class="form-control '.$detalle['tipo'].'" name="'.$request->id.'['.$request->position.']['.$key.']">';
                      $item .= '<option selected="selected" disabled="disabled" hidden="hidden" value="">Selecciona una opción ...</option>';
                      foreach($detalle['datos'] as $key => $dato){
                          $item .= '<option value="'.$key.'">'.$dato.'</option>';
                      }
                      $item .= '</select>';
                      break;
                  case 'modal':
                      $item .= '<td align="center">';
                      $item.= '<button class="btn btn-primary glyphicon glyphicon-pencil agregaItemModal">'.
                              '<input type="hidden" class="itemModalLabel" value="'.$detalle['nombre'].'">'.
                              '<input type="hidden" class="itemModalId" value="'.$request->id.'.'.$request->position.'.'.$key.'">'.
                              '<input type="hidden" class="itemModalToken" id="'. $request->id .'-'.$request->position.'-'. $key .'" value=""'.
                                     'name="' . $request->id .'['.$request->position.']['. $key .']">'.
                              '</button>';
                      break;
                  default:
                      $placeholder = (isset($detalle['nombre']))?$detalle['nombre']:$key;
                      $item .= '<td>';
                      $item .= '<input class="form-control '.$detalle['tipo'].'" type="text" name="'.$request->id.'['.$request->position.']['.$key.']" required="required">';
              }
              $item .= '</td>';
          }
      }
      $item .= '<td align="center">
                  <button type="button" class="btn btn-danger btn-delItem">
                    <span class="glyphicon glyphicon-trash"></span>
                  </button>
                </td>';
      $item .= '</tr>';
      
      return json_encode(['item'=>$item,'id'=>'#tabla-'.$request->id]);       
  }

  public function nuevoItemModal(Request $request){
      \Session::reflash();
      $detalles = \App\StaticContent::obtieneDetalleFSVTE(\Session::get('faseActual'),$request->id);
      $id = explode('.',$request->id);
      $padre = (count($id)==2)?$id[0].'['.$id[1].']':$id[0].'['.$id[1].']['.$id[2].']';
      $link = (count($id)==2)?$id[0].'-'.$id[1]:$id[0].'-'.$id[1].'-'.$id[2];

      if($request->itemToken != ''){
          $itemToken = json_decode(base64_decode($request->itemToken),true);
      }else{
          $itemToken = null;
      }
      $item = '<form id="formItemModal">';
      $item .= '<table class="table table-striped table-bordered">';
      $item .= '<input type="hidden" id="idItemModal" name="idItemModal" value="'.$link.'">';
      foreach($detalles as $key=>$detalle){
          if($detalle['tipo'] != 'index'){
              if(!isset($detalle['default'])){
                  if(!is_null($itemToken)){
                      $value=$itemToken[$key];
                  }else{
                      $value='';
                  }

                  $item .= '<tr>';
                  $item .= '<td align="left">'.$detalle['nombre'].'</td>';
                  switch($detalle['tipo']){
                      case 'textarea':
                          $item .= '<td><textarea class="form-control"
                                              name="'.$padre.'['.$key.']">'.$value.'</textarea></td>';
                          break;
                      case 'select':
                          $item .= '<td><select class="form-control" name="'.$padre.'['.$key.']">';
                          foreach($detalle['datos'] as $key => $dato){
                              if($key==$value) $selected='selected'; else $selected='';
                              $item .= '<option value="'.$key.'" '.$selected.'>'.$dato.'</option>';
                          }
                          $item .= '</select></td>';
                          break;
                      case 'date':
                          $item .= '<td><input class="form-control" type="date"
                                       value="'.$value.'"
                                       name="'.$padre.'['.$key.']"></td>';
                      break;                        
                      default:
                          $placeholder = (isset($detalle['nombre']))?$detalle['nombre']:$key;
                          $item .= '<td><input class="form-control" type="text"
                                           value="'.$value.'"
                                           name="'.$padre.'['.$key.']"
                                           placeholder="ingrese '.$placeholder.'"></td>';
                  }
                  $item .= '</tr>';
              }else{
                  $item .= '<input name="'.$padre.'['.$key.']" type="hidden" value="'.$detalle['default'].'">';
              }
          }
      }
      $item .= '<td align="center">
                  <button type="button" class="btn btn-danger cargaItemModal">
                    <span class="glyphicon glyphicon-floppy-save"></span>
                    &nbsp;Guardar
                  </button>
                </td>';
      $item .= '</table></form>';
      
      return json_encode(['item'=>$item,'id'=>'#tabla-'.$request->id]);       
  }

  public function cargaItemModal(Request $request){ 
      $variable = explode('-',$request->idItemModal); 
      if(count($variable)==2){
          $variable = $variable[0];
          $data = $request->$variable;
      }else{
          $posicion = $variable[1];
          $variable = $variable[0]; 
          $data = $request->$variable; 
          $data = $data[$posicion];
      }

      $retorno = base64_encode(json_encode(collect($data)->first()));
      return ['item'=>$retorno];
  }

  // public function firmaTitular(Request $request){
  //   \Session::reflash();
  //   \Session::forget('_id');
  //   \Session::forget('created');
  //   \Session::forget('fase');
  //   \Session::forget('faseActualDatos');
  //   $util = new Utilidades();
  //   $viatico = $request['f'];
  //   $session = $request['sess'];
  //   $json = $util->muleConnection('GET','/viaticos/schemaViaticos?token='.$session.'&viatico='.$viatico, 10010);
  //    if($json['error']['code']==0){
  //       \Session::put('_id',$json['data']['_id']);
  //       \Session::put('created',$json['data']['created']);
  //       unset($json['data']['created']); 
  //       unset($json['data']['fase']);
  //       unset($json['data']['cdmxIdCreated']);
  //       unset($json['data']['activo']);
  //       foreach($json['data'] as $fase=>$data){
  //         \Session::put('fase.'.$fase,$data);
  //       }
  //       \Session::put('faseActual',$fase);
  //       $datos = $json;
  //       return view('fsvte.infoTitular', compact('datos'));
  //   }else{
  //       return redirect('/svte');
  //   }
  // }

  // public function firmaDga(Request $request){
  //   \Session::reflash();
  //   \Session::forget('_id');
  //   \Session::forget('created');
  //   \Session::forget('fase');
  //   \Session::forget('faseActualDatos');
  //   $util = new Utilidades();
  //   $viatico = $request['f'];
  //   $session = $request['sess'];
  //   $json = $util->muleConnection('GET','/viaticos/schemaViaticos?token='.$session.'&viatico='.$viatico, 10010);
  //    if($json['error']['code']==0){
  //       \Session::put('_id',$json['data']['_id']);
  //       \Session::put('created',$json['data']['created']);
  //       unset($json['data']['created']); 
  //       unset($json['data']['fase']);
  //       unset($json['data']['cdmxIdCreated']);
  //       unset($json['data']['activo']);
  //       foreach($json['data'] as $fase=>$data){
  //         \Session::put('fase.'.$fase,$data);
  //       }
  //       \Session::put('faseActual',$fase);
  //       $datos = $json;
  //       return view('fsvte.infoDga', compact('datos'));
  //   }else{
  //       return redirect('/svte');
  //   }
  // }

  // public function muestraPDFFirma(Request $request){
  //   $util = new Utilidades();
  //   $viatico = \Session::get('_id');
  //   $session = \Session::get('sessionId');
  //   $json = $util->muleConnection('GET','/viaticos/schemaViaticos?token='.$session.'&viatico='.$viatico, 10010);
  //   if ($json['error']['code'] == 0) {
  //     $json['data']['created']=Utilidades::convertidorFecha($json['data']['created'],'unix');
  //     switch ($json['data']['status']) {
  //       case 'captura':
  //         $json['data']['status'] = 'En proceso de Captura';
  //         break;
  //       case 'firmaTitular':
  //         $json['data']['status'] = 'En Firma del Titular';
  //         break;
  //       case 'firmaDGA':
  //         $json['data']['status'] = 'En Firma del DGA';
  //         break;
  //       case 'Autorizado':
  //         $json['data']['status'] = 'Autorizado';
  //         break;
  //     }
  //     $paper_size = array(0,0,612.00,792.00);
  //     switch ($json['data']['detalleComision']['nombre']) {
  //       case 'nacional':
  //         $templateDoc = 'pdf.consNacional';
  //         break;
        
  //       case 'internacional':
  //         $templateDoc = 'pdf.consInternacional';
  //         break;
  //     }
  //     $pdf =  base64_encode(\PDF::loadHTML(\View::make($templateDoc)->with($json['data']))
  //       ->setPaper($paper_size, 'portrait')
  //       ->setWarnings(false)->stream());
  //     return ['pdf'=>$pdf];
  //   }else{
  //     $retorno = json_encode(['color'=>'#C6383D',
  //       'error'=>$json['error']['code'],
  //       'msg'=>$json['error']['msg']
  //     ]);
  //   }
  //   return $retorno;
  // }

  // public function firma(Request $request){
  //   if(\Session::has('firmaactiva')){
  //     $util = new Utilidades();
  //     $viatico = \Session::get('_id');
  //     $tipoViatico = \Session::get('fase.detalleComision.nombre');
  //     $retorno = $this->muestraPDFFirma($request);
  //     $pdf = base64_decode($retorno['pdf']);
  //     \Storage::disk('files')->put('/'.'viaticos'.'/'.$tipoViatico.'/'.$viatico.'/'.$request->docId.'.pdf',$pdf);
  //     $parametros = [
  //       'data' => [
  //         'nombreDir' => '/'.'viaticos'.'/'.$tipoViatico.'/'.$viatico.'/',
  //         'separador' => '/',
  //         'archivoenv' => [$request->docId.'.pdf']
  //       ]
  //     ];
  //     $retorno = $util->muleConnection('POST','/viaticos/moveFileViewToMule',10010,$parametros);
  //     if($retorno['error']['code']==0){
  //       $parametros = [
  //         'security' => ['cdmxId'=>\Session::get('cdmxId')],
  //         'data' => ['system' => 'Viatinet',
  //           'pathrelativo' => '',
  //           'password' => \Session::get('password') ,
  //           'nombre' => '/'.'viaticos'.'/'.$tipoViatico.'/'.$viatico.'/'.$request->docId.'.pdf',
  //           'byteKey'=> \Session::get('bytekey'),
  //           'bytecer' => \Session::get('bytecer'), 
  //           'tipofirma' => '1'
  //         ]
  //       ];
  //       $retorno = $util->muleConnection('POST','/externs/signedFIELCDMX',9005,$parametros);
  //       if($retorno['error']['code']==0){            
  //         $archivo = $request->docId.'.pdf';
  //         $archivoFirmado = $request->docId.'firmado.pdf';
  //         $parametros = [
  //           'data' => ['nombreDir' => '/'.'viaticos'.'/'.$tipoViatico.'/'.$viatico,
  //              'separador' => '/',
  //              'archivoenv' => [$archivo,$archivoFirmado]
  //           ]
  //         ];
  //         $retorno = $util->muleConnection('POST','/viaticos/moveFileMuleToStorage',10010,$parametros);
  //         if($retorno['error']['code'] == 0){
  //           $respuesta = $util->muleConnection('GET','/viaticos/statusFwd?token='.\Session::get('sessionId').'&viatico='.$viatico,10010);
  //           if($respuesta['error']['code'] == 0){
  //             return ['error'=>['code'=>0,'msg'=>'Se ha finalizado el proceso correctamente'],'color'=>'blue'];
  //           }else{
  //             return ['error'=>['code'=>1,'msg'=>'Ha fallado el proceso de firmado'],'color'=>'#C6383D'];
  //           }
  //         }else{
  //           return ['error'=>['code'=>3,'msg'=>'Ha fallado el proceso de firmado'],'color'=>'#C6383D'];
  //         }
  //       }else{
  //         return ['error'=>['code'=>4,'msg'=>'Ha fallado el proceso de firmado'],'color'=>'#C6383D'];
  //       }
  //     }else{
  //       return ['error'=>['code'=>5,'msg'=>'Ha fallado el proceso de firmado'],'color'=>'#C6383D'];
  //     }
  //   }else{
  //     return ['error'=>['code'=>1,'msg'=>'No haz cargado la Firma Electrónica'],'color'=>'#C6383D'];
  //   }
  // }

  // public function setFirma(Request $request){ 
  //   if(!$request->hasFile('cer') || !$request->hasFile('key') || trim($request->password)==''){
  //     \Session::put('firmaincorrecta',true);
  //   }else{
  //     $bytecert = base64_encode(\File::get($request->cer->path()));
  //     $byteKey = base64_encode(\File::get($request->key->path()));
  //     $password = base64_encode($request->password);
  //     $util = new Utilidades();
  //     $parametros = ['data' => [
  //         'password' => $password,
  //         'byteKey' => $byteKey,
  //         'bytecer' => $bytecert
  //       ]
  //     ];
  //     $respuesta = $util->muleConnection('POST','/externs/validarDatosFirma',9005,$parametros);
  //     if($respuesta['error']['code'] == 0){
  //       \Session::put('bytecer', $bytecert);
  //       \Session::put('bytekey', $byteKey);
  //       \Session::put('password', $password);
  //       \Session::put('firmaactiva', true);  
  //     }else{
  //       \Session::put('firmaincorrecta',true);
  //       flash($respuesta['error']['msg'])->error();
  //       return redirect('/svte');
  //     }  
  //   }
  //   return redirect('/svte');
  // }

  // public function setFirmainsidePage(Request $request){ 
  //   if(!$request->hasFile('cer') || !$request->hasFile('key') || trim($request->password)==''){
  //     \Session::put('firmaincorrecta',true);
  //   }else{
  //     $bytecert = base64_encode(\File::get($request->cer->path()));
  //     $byteKey = base64_encode(\File::get($request->key->path()));
  //     $password = base64_encode($request->password);
  //     $util = new Utilidades();
  //     $parametros = ['data' => [
  //         'password' => $password,
  //         'byteKey' => $byteKey,
  //         'bytecer' => $bytecert
  //       ]
  //     ];
  //     $respuesta = $util->muleConnection('POST','/externs/validarDatosFirma',9005,$parametros);
  //     if($respuesta['error']['code'] == 0){
  //       \Session::put('bytecer', $bytecert);
  //       \Session::put('bytekey', $byteKey);
  //       \Session::put('password', $password);
  //       \Session::put('firmaactiva', true);  
  //     }else{
  //       \Session::put('firmaincorrecta',true);
  //       flash($respuesta['error']['msg'])->error();
  //       return redirect(\URL::previous());
  //     }  
  //   }
  //   return redirect(\URL::previous());
  // }

  // public function forgetFirma(Request $request){ 
  //   \Session::forget('bytecer');
  //   \Session::forget('bytekey');
  //   \Session::forget('password');
  //   \Session::forget('firmaactiva');         
  //   return redirect(\URL::previous());
  // }

  // public function exportcsv(){
  //   $items = $this->obtieneFichas();
  //   if (\Session::get('user.roles')->contains('Viatinet_Operativo')) {
  //     if(count($items) != 0){
  //       \Excel::create('comisionados_'.\Session::get('user.roles.1'), function($excel) use($items) {
  //         $excel->sheet('File', function($sheet) use($items) {
  //           $sheet->setAutoFilter('A1:AK1');
  //           $sheet->setColumnFormat(array(
  //               'Y:AK' => '"$"#,##0.00'
  //           ));
  //           $sheet->setAutoSize(array(
  //             'A', 'B', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'W', 'X', 'Y', 'Z', 'AA'
  //           ));
  //           $sheet->setWidth(array(
  //             'U' => 40,
  //             'V' => 40,
  //             'AB' => 20,
  //             'AC' => 20,
  //             'AD' => 20,
  //             'AE' => 20,
  //             'AF' => 20,
  //             'AG' => 20,
  //             'AH' => 20,
  //             'AI' => 20,
  //             'AJ' => 20,
  //             'AK' => 20,
  //           ));
  //           $sheet->loadView('pdf.excel')->with('items', $items);
  //         });
  //       }, 'UTF-8')->export('xlsx');
  //     }else{
  //       flash('No hay datos para exportar!!!')->error();
  //       return redirect('/svte'); 
  //     }
  //   }elseif (\Session::get('user.roles')->contains('Viatinet_Titular') || (\Session::get('user.roles')->contains('Viatinet_supTitular'))) {
  //     if(count($items) != 0){
  //       \Excel::create('comisionados_'.\Session::get('user.roles.1'), function($excel) use($items) {
  //         $excel->sheet('File', function($sheet) use($items) {
  //           $sheet->setAutoFilter('A1:AK1');
  //           $sheet->setColumnFormat(array(
  //               'Y:AK' => '"$"#,##0.00'
  //           ));
  //           $sheet->setAutoSize(array(
  //             'A', 'B', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'W', 'X', 'Y', 'Z', 'AA'
  //           ));
  //           $sheet->setWidth(array(
  //             'U' => 40,
  //             'V' => 40,
  //             'AB' => 20,
  //             'AC' => 20,
  //             'AD' => 20,
  //             'AE' => 20,
  //             'AF' => 20,
  //             'AG' => 20,
  //             'AH' => 20,
  //             'AI' => 20,
  //             'AJ' => 20,
  //             'AK' => 20,
  //           ));            
  //           $sheet->loadView('pdf.excel')->with('items', $items);
  //         });
  //       }, 'UTF-8')->export('xlsx');
  //     }else{
  //       flash('No hay datos para exportar!!!')->error();
  //       return redirect('/svte'); 
  //     }
  //   }elseif (\Session::get('user.roles')->contains('Viatinet_Dga') || (\Session::get('user.roles')->contains('Viatinet_supDga'))) {
  //     if(count($items) != 0){
  //       \Excel::create('comisionados_'.\Session::get('user.roles.1'), function($excel) use($items) {
  //         $excel->sheet('File', function($sheet) use($items) {
  //           $sheet->setAutoFilter('A1:AK1');
  //           $sheet->setColumnFormat(array(
  //               'Y:AK' => '"$"#,##0.00'
  //           ));
  //           $sheet->setAutoSize(array(
  //             'A', 'B', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'W', 'X', 'Y', 'Z', 'AA'
  //           ));
  //           $sheet->setWidth(array(
  //             'U' => 40,
  //             'V' => 40,
  //             'AB' => 20,
  //             'AC' => 20,
  //             'AD' => 20,
  //             'AE' => 20,
  //             'AF' => 20,
  //             'AG' => 20,
  //             'AH' => 20,
  //             'AI' => 20,
  //             'AJ' => 20,
  //             'AK' => 20,
  //           ));
  //           $sheet->loadView('pdf.excel')->with('items', $items);
  //         });
  //       }, 'UTF-8')->export('xlsx');
  //     }else{
  //       flash('No hay datos para exportar!!!')->error();
  //       return redirect('/svte'); 
  //     }
  //   }
  // }

  // public function exportcsvAut(){
  //   $items = $this->obtieneFichasAutorizadas();
  //   if (\Session::get('user.roles')->contains('Viatinet_Operativo')) {
  //     if(count($items) != 0){
  //       \Excel::create('comisionados_autorizado_'.\Session::get('user.roles.1'), function($excel) use($items) {
  //         $excel->sheet('File', function($sheet) use($items) {
  //           $sheet->setAutoFilter('A1:AK1');
  //           $sheet->setColumnFormat(array(
  //               'Y:AK' => '"$"#,##0.00'
  //           ));
  //           $sheet->setAutoSize(array(
  //             'A', 'B', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'W', 'X', 'Y', 'Z', 'AA'
  //           ));
  //           $sheet->setWidth(array(
  //             'U' => 40,
  //             'V' => 40,
  //             'AB' => 20,
  //             'AC' => 20,
  //             'AD' => 20,
  //             'AE' => 20,
  //             'AF' => 20,
  //             'AG' => 20,
  //             'AH' => 20,
  //             'AI' => 20,
  //             'AJ' => 20,
  //             'AK' => 20,
  //           ));
  //           $sheet->loadView('pdf.excel')->with('items', $items);
  //         });
  //       }, 'UTF-8')->export('xlsx');
  //     }else{
  //       flash('No hay datos para exportar!!!')->error();
  //       return redirect(\URL::previous()); 
  //     }
  //   }elseif (\Session::get('user.roles')->contains('Viatinet_Titular') || (\Session::get('user.roles')->contains('Viatinet_supTitular'))) {
  //     if(count($items) != 0){
  //       \Excel::create('comisionados_autorizado_'.\Session::get('user.roles.1'), function($excel) use($items) {
  //         $excel->sheet('File', function($sheet) use($items) {
  //           $sheet->setAutoFilter('A1:AK1');
  //           $sheet->setColumnFormat(array(
  //               'Y:AK' => '"$"#,##0.00'
  //           ));
  //           $sheet->setAutoSize(array(
  //             'A', 'B', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'W', 'X', 'Y', 'Z', 'AA'
  //           ));
  //           $sheet->setWidth(array(
  //             'U' => 40,
  //             'V' => 40,
  //             'AB' => 20,
  //             'AC' => 20,
  //             'AD' => 20,
  //             'AE' => 20,
  //             'AF' => 20,
  //             'AG' => 20,
  //             'AH' => 20,
  //             'AI' => 20,
  //             'AJ' => 20,
  //             'AK' => 20,
  //           ));
  //           $sheet->loadView('pdf.excel')->with('items', $items);
  //         });
  //       }, 'UTF-8')->export('xlsx');
  //     }else{
  //       flash('No hay datos para exportar!!!')->error();
  //       return redirect(\URL::previous()); 
  //     }
  //   }elseif (\Session::get('user.roles')->contains('Viatinet_Dga') || (\Session::get('user.roles')->contains('Viatinet_supDga'))) {
  //     if(count($items) != 0){
  //       \Excel::create('comisionados_autorizado_'.\Session::get('user.roles.1'), function($excel) use($items) {
  //         $excel->sheet('File', function($sheet) use($items) {
  //           $sheet->setAutoFilter('A1:AK1');
  //           $sheet->setColumnFormat(array(
  //               'Y:AK' => '"$"#,##0.00'
  //           ));
  //           $sheet->setAutoSize(array(
  //             'A', 'B', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'W', 'X', 'Y', 'Z', 'AA'
  //           ));
  //           $sheet->setWidth(array(
  //             'U' => 40,
  //             'V' => 40,
  //             'AB' => 20,
  //             'AC' => 20,
  //             'AD' => 20,
  //             'AE' => 20,
  //             'AF' => 20,
  //             'AG' => 20,
  //             'AH' => 20,
  //             'AI' => 20,
  //             'AJ' => 20,
  //             'AK' => 20,
  //           ));
  //           $sheet->loadView('pdf.excel')->with('items', $items);
  //         });
  //       }, 'UTF-8')->export('xlsx');
  //     }else{
  //       flash('No hay datos para exportar!!!')->error();
  //       return redirect(\URL::previous()); 
  //     }
  //   }
  // }

  // public function exportcsvRech(){
  //   $items = $this->obtieneFichasRechazadas();
  //   if (\Session::get('user.roles')->contains('Viatinet_Operativo')) {
  //     if(count($items) != 0){
  //       \Excel::create('comisionados_rechazados_'.\Session::get('user.roles.1'), function($excel) use($items) {
  //         $excel->sheet('File', function($sheet) use($items) {
  //           $sheet->setAutoFilter('A1:AK1');
  //           $sheet->setColumnFormat(array(
  //               'Y:AK' => '"$"#,##0.00'
  //           ));
  //           $sheet->setAutoSize(array(
  //             'A', 'B', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'W', 'X', 'Y', 'Z', 'AA'
  //           ));
  //           $sheet->setWidth(array(
  //             'U' => 40,
  //             'V' => 40,
  //             'AB' => 20,
  //             'AC' => 20,
  //             'AD' => 20,
  //             'AE' => 20,
  //             'AF' => 20,
  //             'AG' => 20,
  //             'AH' => 20,
  //             'AI' => 20,
  //             'AJ' => 20,
  //             'AK' => 20,
  //           ));
  //           $sheet->loadView('pdf.excel')->with('items', $items);
  //         });
  //       }, 'UTF-8')->export('xlsx');
  //     }else{
  //       flash('No hay datos para exportar!!!')->error();
  //       return redirect(\URL::previous()); 
  //     }
  //   }elseif (\Session::get('user.roles')->contains('Viatinet_Titular') || (\Session::get('user.roles')->contains('Viatinet_supTitular'))) {
  //     if(count($items) != 0){
  //       \Excel::create('comisionados_rechazados_'.\Session::get('user.roles.1'), function($excel) use($items) {
  //         $excel->sheet('File', function($sheet) use($items) {
  //           $sheet->setAutoFilter('A1:AK1');
  //           $sheet->setColumnFormat(array(
  //               'Y:AK' => '"$"#,##0.00'
  //           ));
  //           $sheet->setAutoSize(array(
  //             'A', 'B', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'W', 'X', 'Y', 'Z', 'AA'
  //           ));
  //           $sheet->setWidth(array(
  //             'U' => 40,
  //             'V' => 40,
  //             'AB' => 20,
  //             'AC' => 20,
  //             'AD' => 20,
  //             'AE' => 20,
  //             'AF' => 20,
  //             'AG' => 20,
  //             'AH' => 20,
  //             'AI' => 20,
  //             'AJ' => 20,
  //             'AK' => 20,
  //           ));
  //           $sheet->loadView('pdf.excel')->with('items', $items);
  //         });
  //       }, 'UTF-8')->export('xlsx');
  //     }else{
  //       flash('No hay datos para exportar!!!')->error();
  //       return redirect(\URL::previous()); 
  //     }
  //   }elseif (\Session::get('user.roles')->contains('Viatinet_Dga') || (\Session::get('user.roles')->contains('Viatinet_supDga'))) {
  //     if(count($items) != 0){
  //       \Excel::create('comisionados_rechazados_'.\Session::get('user.roles.1'), function($excel) use($items) {
  //         $excel->sheet('File', function($sheet) use($items) {
  //           $sheet->setAutoFilter('A1:AK1');
  //           $sheet->setColumnFormat(array(
  //               'Y:AK' => '"$"#,##0.00'
  //           ));
  //           $sheet->setAutoSize(array(
  //             'A', 'B', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'W', 'X', 'Y', 'Z', 'AA'
  //           ));
  //           $sheet->setWidth(array(
  //             'U' => 40,
  //             'V' => 40,
  //             'AB' => 20,
  //             'AC' => 20,
  //             'AD' => 20,
  //             'AE' => 20,
  //             'AF' => 20,
  //             'AG' => 20,
  //             'AH' => 20,
  //             'AI' => 20,
  //             'AJ' => 20,
  //             'AK' => 20,
  //           ));
  //           $sheet->loadView('pdf.excel')->with('items', $items);
  //         });
  //       }, 'UTF-8')->export('xlsx');
  //     }else{
  //       flash('No hay datos para exportar!!!')->error();
  //       return redirect(\URL::previous()); 
  //     }
  //   }
  // }

  // public function observacionesTitular(Request $request){
  //   $user = 'Titular';
  //   $viatico = \Session::get('_id');
  //   $observacionDC = $request->input('commentDetalleComision');
  //   $observacionRP = $request->input('commentRegistroPersonal');
  //   $guardaTipo = $request->input('guardaTipo');
  //   $util = new Utilidades();
  //   if ($guardaTipo == 'nacional') { $etapa = 'registroPersonalNacional'; }else{$etapa = 'registroPersonalInternacional'; } 
  //   if ($observacionDC != '' && $observacionRP != '' || $observacionDC != '' || $observacionRP != '') {
  //     if ($request->checkboxDetalleComision == true && $request->checkboxRegistroPersonal == true) {
  //       $parametros = [
  //         'security' => [      
  //           'sessionId' => \Session::get('sessionId')
  //         ],
  //         'data' => [
  //           'idViatico' => $viatico,          
  //           'etapa' => 'detalleComision',
  //           'responsable' => $user,
  //           'observaciones' => $observacionDC,  
  //         ]
  //       ];
  //       $parametros2 = [
  //         'security' => [      
  //           'sessionId' => \Session::get('sessionId')
  //         ],
  //         'data' => [
  //           'idViatico' => $viatico,          
  //           'etapa' => $etapa,
  //           'responsable' => $user,
  //           'observaciones' => $observacionRP,
  //         ]
  //       ];
  //       // dd(json_encode([$parametros, $parametros2]));
  //       $json = $util->muleConnection('POST','/viaticos/statusBwd',10010,$parametros);
  //       // dd($json);
  //       if ($json['error']['code'] == 0) {
  //         $json2 = $util->muleConnection('POST','/viaticos/statusBwd',10010,$parametros2);
  //         if ($json2['error']['code'] == 0) {
  //           flash($json2['error']['msg']);
  //           return redirect('/rechazadoTitular');
  //         }else{
  //           flash($json2['error']['msg'])->error();
  //           return redirect(\URL::previous());          
  //         }
  //       }else{
  //         flash($json['error']['msg'])->error();
  //         return redirect(\URL::previous()); 
  //       }
  //     }elseif ($request->checkboxDetalleComision == true && $request->checkboxRegistroPersonal == false) {
  //       $parametros = [
  //         'security' => [      
  //           'sessionId' => \Session::get('sessionId')
  //         ],
  //         'data' => [
  //           'idViatico' => $viatico,          
  //           'etapa' => 'detalleComision',
  //           'responsable' => $user,
  //           'observaciones' => $observacionDC,  
  //         ]
  //       ];
  //       $json = $util->muleConnection('POST','/viaticos/statusBwd',10010,$parametros);
  //       if ($json['error']['code'] == 0) {
  //         flash($json['error']['msg']);
  //         return redirect('/rechazadoTitular');
  //       }else{
  //         flash($json['error']['msg'])->error();
  //         return redirect(\URL::previous());      
  //       }
  //     }elseif ($request->checkboxDetalleComision == false && $request->checkboxRegistroPersonal == true) {
  //       $parametros = [
  //         'security' => [      
  //           'sessionId' => \Session::get('sessionId')
  //         ],
  //         'data' => [
  //           'idViatico' => $viatico,          
  //           'etapa' => $etapa,
  //           'responsable' => $user,
  //           'observaciones' => $observacionRP,
  //         ]
  //       ];
  //       $json = $util->muleConnection('POST','/viaticos/statusBwd',10010,$parametros);
  //       if ($json['error']['code'] == 0) {
  //         flash($json['error']['msg']);
  //         return redirect('/rechazadoTitular');
  //       }else{
  //         flash($json['error']['msg'])->error();
  //         return redirect(\URL::previous());          
  //       }        
  //     }
  //   }else{
  //     flash('Error verifica los campos vacios!!!')->error();
  //     return redirect(\URL::previous());
  //   }
  // }

  // public function observacionesDga(Request $request){
  //   $user = 'DGA';
  //   $viatico = \Session::get('_id');
  //   $observacionDC = $request->input('commentDetalleComision');
  //   $observacionRP = $request->input('commentRegistroPersonal');
  //   $guardaTipo = $request->input('guardaTipo');
  //   $util = new Utilidades();
  //   if ($guardaTipo == 'nacional') { $etapa = 'registroPersonalNacional'; }else{$etapa = 'registroPersonalInternacional'; } 
  //   if ($observacionDC != '' && $observacionRP != '' || $observacionDC != '' || $observacionRP != '') {
  //     if ($request->checkboxDetalleComision == true && $request->checkboxRegistroPersonal == true) {
  //       $parametros = [
  //         'security' => [      
  //           'sessionId' => \Session::get('sessionId')
  //         ],
  //         'data' => [
  //           'idViatico' => $viatico,
  //           'etapa' => 'detalleComision',
  //           'responsable' => $user,
  //           'observaciones' => $observacionDC,
  //         ]
  //       ];
  //       $parametros2 = [
  //         'security' => [      
  //           'sessionId' => \Session::get('sessionId')
  //         ],
  //         'data' => [
  //           'idViatico' => $viatico,          
  //           'etapa' => $etapa,
  //           'responsable' => $user,
  //           'observaciones' => $observacionRP,
  //         ]
  //       ];
  //       $json = $util->muleConnection('POST','/viaticos/statusBwd',10010, $parametros);
  //       // dd($json);
  //       if ($json['error']['code'] == 0) {
  //         $json2 = $util->muleConnection('POST','/viaticos/statusBwd',10010,$parametros2);
  //         if ($json2['error']['code'] == 0) {
  //           flash($json2['error']['msg']);
  //           return redirect('/rechazadoDga');
  //         }else{
  //           flash($json2['error']['msg'])->error();
  //           return redirect(\URL::previous());          
  //         }
  //       }else{
  //         flash($json['error']['msg'])->error();
  //         return redirect(\URL::previous()); 
  //       }
  //     }elseif ($request->checkboxDetalleComision == true && $request->checkboxRegistroPersonal == false) {
  //       $parametros = [
  //         'security' => [      
  //           'sessionId' => \Session::get('sessionId')
  //         ],
  //         'data' => [
  //           'idViatico' => $viatico,          
  //           'etapa' => 'detalleComision',
  //           'responsable' => $user,
  //           'observaciones' => $observacionDC,  
  //         ]
  //       ];
  //       $json = $util->muleConnection('POST','/viaticos/statusBwd',10010,$parametros);
  //       if ($json['error']['code'] == 0) {
  //         flash($json['error']['msg']);
  //         return redirect('/rechazadoDga');
  //       }else{
  //         flash($json['error']['msg'])->error();
  //         return redirect(\URL::previous());         
  //       }
  //     }elseif ($request->checkboxDetalleComision == false && $request->checkboxRegistroPersonal == true) {
  //       $parametros = [
  //         'security' => [      
  //           'sessionId' => \Session::get('sessionId')
  //         ],
  //         'data' => [
  //           'idViatico' => $viatico,          
  //           'etapa' => $etapa,
  //           'responsable' => $user,
  //           'observaciones' => $observacionRP,
  //         ]
  //       ];
  //       $json = $util->muleConnection('POST','/viaticos/statusBwd',10010,$parametros);
  //       if ($json['error']['code'] == 0) {
  //         flash($json['error']['msg']);
  //         return redirect('/rechazadoDga');
  //       }else{
  //         flash($json['error']['msg'])->error();
  //         return redirect(\URL::previous());           
  //       }        
  //     }
  //   }else{
  //     flash('Error verifica los campos vacios!!!')->error();
  //     return redirect(\URL::previous());
  //   }
  // }

  // public function muestraPDFFirmaTitular(Request $request){
  //   $util = new Utilidades();
  //   $session = \Session::get('sessionId');
  //   $viatico = $request->input('docId');
  //   $json = $util->muleConnection('GET','/viaticos/schemaViaticos?token='.$session.'&viatico='.$viatico, 10010);
  //   if ($json['error']['code'] == 0) {
  //     $dirPath = '/'.'viaticos'.'/'.$json['data']['detalleComision']['nombre'].'/'.$json['data']['_id'].'/';
  //     $baseName = $json['data']['_id'].'firmado.pdf';
  //     $parametros = [
  //       'data' => [
  //         'nombreDir' => $dirPath,
  //         'separador'=>'/',
  //         'archivoenv'=>[$baseName]
  //       ]
  //     ];
  //     $retorno = $util->muleConnection('POST','/viaticos/copyFileStorageToView',10010,$parametros);
  //     if($retorno['error']['code'] == 0){
  //       if(\Storage::disk('files')->exists('descarga'.$dirPath.'/'.$baseName)){
  //         $pdf = base64_encode(\Storage::disk('files')->get('descarga'.$dirPath.'/'.$baseName));
  //       }else{ 
  //         $pdf = base64_encode(\PDF::loadHTML(\View::make('errors.pdfNotFound'))->setWarnings(false)->stream());
  //       }
  //       return ['pdf'=>$pdf];
  //     }else{
  //       return ['error'=>['code'=>1,'msg'=>$retorno['error']['msg']],'color'=>'#C6383D'];      
  //     }
  //   }else{
  //     return ['error'=>['code'=>1,'msg'=>$json['error']['msg']],'color'=>'#C6383D'];
  //   }
  // }

  // public function muestraPDFAutorizado(Request $request){
  //   $util = new Utilidades();
  //   $session = \Session::get('sessionId');
  //   $viatico = $request->input('docId');
  //   $json = $util->muleConnection('GET','/viaticos/schemaViaticos?token='.$session.'&viatico='.$viatico, 10010);
  //   if ($json['error']['code'] == 0) {
  //     $dirPath = '/'.'viaticos'.'/'.$json['data']['detalleComision']['nombre'].'/'.$json['data']['_id'].'/';
  //     $baseName = $json['data']['_id'].'Titularfirmado.pdf';
  //     $parametros = [
  //       'data' => [
  //         'nombreDir' => $dirPath,
  //         'separador'=>'/',
  //         'archivoenv'=>[$baseName]
  //       ]
  //     ];
  //     $retorno = $util->muleConnection('POST','/viaticos/copyFileStorageToView',10010,$parametros);
  //     if($retorno['error']['code'] == 0){
  //       if(\Storage::disk('files')->exists('descarga'.$dirPath.'/'.$baseName)){
  //         $pdf = base64_encode(\Storage::disk('files')->get('descarga'.$dirPath.'/'.$baseName));
  //       }else{ 
  //         $pdf = base64_encode(\PDF::loadHTML(\View::make('errors.pdfNotFound'))->setWarnings(false)->stream());
  //       }
  //       return ['pdf'=>$pdf];
  //     }else{
  //       return ['error'=>['code'=>1,'msg'=>$retorno['error']['msg']],'color'=>'#C6383D'];      
  //     }
  //   }else{
  //     return ['error'=>['code'=>1,'msg'=>$json['error']['msg']],'color'=>'#C6383D'];
  //   }
  // }

  // public function muestraPDFFirmaDga(Request $request){
  //   $util = new Utilidades();
  //   $session = \Session::get('sessionId');
  //   $viatico = $request->input('docId');
  //   $json = $util->muleConnection('GET','/viaticos/schemaViaticos?token='.$session.'&viatico='.$viatico, 10010);
  //   if ($json['error']['code'] == 0) {
  //     $dirPath = '/'.'viaticos'.'/'.$json['data']['detalleComision']['nombre'].'/'.$json['data']['_id'].'/';
  //     $baseName = $json['data']['_id'].'firmado.pdf';
  //     $parametros = [
  //       'data' => [
  //         'nombreDir' => $dirPath,
  //         'separador'=>'/',
  //         'archivoenv'=>[$baseName]
  //       ]
  //     ];
  //     $retorno = $util->muleConnection('POST','/viaticos/copyFileStorageToView',10010,$parametros);
  //     if($retorno['error']['code'] == 0){
  //       if(\Storage::disk('files')->exists('descarga'.$dirPath.'/'.$baseName)){
  //         $pdf = base64_encode(\Storage::disk('files')->get('descarga'.$dirPath.'/'.$baseName));
  //       }else{ 
  //         $pdf = base64_encode(\PDF::loadHTML(\View::make('errors.pdfNotFound'))->setWarnings(false)->stream());
  //       }
  //       return ['pdf'=>$pdf];
  //     }else{
  //       return ['error'=>['code'=>1,'msg'=>$retorno['error']['msg']],'color'=>'#C6383D'];      
  //     }
  //   }else{
  //     return ['error'=>['code'=>1,'msg'=>$json['error']['msg']],'color'=>'#C6383D'];
  //   }
  // }

  // public function autorizaDGA(Request $request){
  //   if(\Session::has('firmaactiva')){
  //     $util = new Utilidades();
  //     $viatico = $request->input('docId');
  //     $tipoViatico = $request->input('nombre');
  //     $dirPath = '/'.'viaticos'.'/'.$tipoViatico.'/'.$viatico.'/';
  //     $nameFirmado = $viatico.'firmado.pdf';
  //     $nameFirmadoTitular = $viatico.'Titular.pdf';
  //     $pathTitular = $dirPath.$nameFirmadoTitular;
  //     $rutaCompleta='/var/www/html/virtual/viaticos/files/plataforma/descarga/viaticos/'.$tipoViatico.'/'.$viatico.'/';
  //     \Storage::disk('files')->put($pathTitular,\File::get($rutaCompleta.$nameFirmado));
  //     $parametros = [
  //       "data"=>[
  //             "nombreDir"=> $dirPath, 
  //             "separador"=>"/", 
  //             "archivoenv"=>[$nameFirmadoTitular]
  //             ]
  //     ];
  //     $json = $util->muleConnection('POST','/viaticos/moveFileViewToMule',10010,$parametros);
  //     if ($json['error']['code'] == 0) {
  //       $parametros = [
  //         'security' => ['cdmxId'=>\Session::get('cdmxId')],
  //         // 'security' => ['cdmxId'=>'0IJDINSXY2ER1N5-781WSQ0U2003039'],
  //         'data' => ['system' => 'Viatinet',
  //           'pathrelativo' => '',
  //           'password' => \Session::get('password') ,
  //           'nombre' => $dirPath.$nameFirmadoTitular,
  //           'byteKey'=> \Session::get('bytekey'),
  //           'bytecer' => \Session::get('bytecer'), 
  //           'tipofirma' => '1'
  //         ]
  //       ];
  //       $json = $util->muleConnection('POST','/externs/signedFIELCDMX',9005,$parametros);
  //       if ($json['error']['code'] == 0) {
  //         $parametros = [
  //           'data' => ['nombreDir' => $dirPath,
  //              'separador' => '/',
  //              'archivoenv' => [$viatico.'Titularfirmado.pdf']
  //           ]
  //         ];
  //         $json = $util->muleConnection('POST','/viaticos/moveFileMuleToStorage',10010,$parametros);
  //           if ($json['error']['code'] == 0) {
  //             $retorno = $util->muleConnection('GET','/viaticos/statusFwd?token='.\Session::get('sessionId').'&viatico='.$viatico,10010);
  //             if($retorno['error']['code']==0){
  //               return ['error'=>['code'=>0,'msg'=>'Se ha finalizado el proceso correctamente'],'color'=>'blue'];
  //             }else{
  //               return ['error'=>['code'=>1,'msg'=>'Ha fallado el proceso de firmado'],'color'=>'#C6383D'];
  //             }
  //           }else{
  //             return ['error'=>['code'=>3,'msg'=>'Ha fallado el proceso de firmado'],'color'=>'#C6383D'];
  //           }
  //       }else{
  //          return ['error'=>['code'=>4,'msg'=>'Ha fallado el proceso de firmado'],'color'=>'#C6383D'];
  //        }
  //     }else{
  //       return ['error'=>['code'=>5,'msg'=>'Ha fallado el proceso de firmado'],'color'=>'#C6383D'];
  //     }
  //   }else{
  //     return ['error'=>['code'=>1,'msg'=>'No haz cargado la Firma Electrónica'],'color'=>'#C6383D'];
  //   }
  // }

  // public function getDetailPDF(Request $request){
  //   if ($request->type != 'Autorizado') {
  //     $documento = new Self();
  //     $request->docId = $request->docId;
  //     $respuesta = $documento->muestraPDFFirmaTitular($request);
  //     return \Response::make(base64_decode($respuesta['pdf']),'200',array(
  //       'Content-Type'=>'application/octet-stream',
  //       'Content-Disposition' => 'attachment;filename="'.$request->docId.'.pdf"'
  //     ));
  //   }else{
  //     $documento = new Self();
  //     $request->docId = $request->docId;
  //     $respuesta = $documento->muestraPDFAutorizado($request);
  //     return \Response::make(base64_decode($respuesta['pdf']),'200',array(
  //       'Content-Type'=>'application/octet-stream',
  //       'Content-Disposition' => 'attachment;filename="'.$request->docId.'.pdf"'
  //     ));
  //   }
  // }

}

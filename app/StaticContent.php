<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaticContent extends Model
{
  const FASES = [
    'datosEmpresa' => [
      'name' => 'Datos de la Empresa',
      'type' => ['prensa','radio', 'television', 'revista', 'internet', 'monitoreo', 'spot', 'filmacion', 'eventosJG', 'cineminuto', 'otro'],
      'upload' => true,
      'data' => [
        'nombreComercial' => [
          'nombre' => 'Nombre Comercial (Empresa)',
          'tipo' => 'string',
          'long' => 250,
          'minLong' => 5,
          'requerido' => true,
          'uppercase' => true
        ],
        'razonSocial' => [
          'nombre' => 'Razón Social',
          'tipo' => 'string',
          'long' => 250,
          'requerido' => true,
          'uppercase' => true
        ],
        'rfcProveedor' => [
          'nombre' => 'Registro Federal del Contribuyente (Empresa)',
          'tipo' => 'rfc',
          'long' => 13,
          'requerido' => true,
          'uppercase' => true
        ],
        'documents'=>[
          'nombre'=>'Sección de documentos',
          'tipo'=>'upload',
          'long'=>100,
          'requerido'=>false,
          'th'=>[
            'Título del documento',
            'Nombre del documento',
          ],
        ]
      ]  
    ],
    'datosContrato' => [
      'name' => 'Datos del contrato',
      'type' => ['prensa','radio', 'television', 'revista', 'internet', 'monitoreo', 'spot', 'filmacion', 'eventosJG', 'cineminuto', 'otro'],
      'upload' => true,
      'data' =>[
        'numeroContrato' =>[
          'nombre' => 'Numero de contrato',
          'tipo' => 'string',
          'minLong' => 12,
          'long' => 250,
          'uppercase' => true,
          'requerido' => true,
        ],
        'montoContrato' => [
          'nombre' => 'Monto Contrato',
          'tipo' => 'double',
          'long' => 250,
          'requerido' => true,
        ],
        'suficienciaPresupuestal' =>[
          'nombre' => 'Suficiencia presupuestal',
          'tipo' => 'string',
          'long' => 250,
          'requerido' => true,
        ],
        'partida' =>[
          'nombre' => 'Partida',
          'tipo' => 'number',
          'long' => 5,
          'requerido' => true,
        ],
        'tipoContratacion' =>[
          'nombre' => 'Tipo de contratación',
          'tipo' => 'string',
          'long' => 250,
          'requerido' => false,
        ],
        'fundamento' =>[
          'nombre' => 'Fundamento',
          'tipo' => 'string',
          'long' => 250,
          'requerido' => false,
        ],
        'fechaFirma' =>[
          'nombre' => 'Fecha de firma',
          'tipo' => 'date',
          'format'=>'c',
          'requerido'=>true,
        ],
        'vigencia' =>[
          'nombre' => 'Vigencia',
          'tipo' => 'date',
          'format'=>'c',
          'requerido'=>true,
        ],
        'recurso' =>[
          'nombre' => 'Recurso',
          'tipo' => 'string',
          'long' => 250,
          'requerido'=>false,
        ],
        'documents'=>[
          'nombre'=>'Sección de documentos',
          'tipo'=>'upload',
          'long'=>100,
          'requerido'=>false,
          'th'=>[
            'Título del documento',
            'Nombre del documento',
          ],
        ]
      ]
    ],
    'apoderadoLegal' => [
      'name' => 'Apoderado legal',
      'type' => ['prensa','radio', 'television', 'revista', 'internet', 'monitoreo', 'spot', 'filmacion', 'eventosJG', 'cineminuto', 'otro'],
      'data'=>[
        'nombreCompleto' => [
          'nombre' => 'Nombre(s)',
          'tipo' => 'string',
          'minLong' => 3,
          'long' => 250,
          'requerido' => true,
          'uppercase' => true
        ],
        'aPaterno' => [
          'nombre' => 'Apellido paterno',
          'tipo' => 'string',
          'minLong' => 3,
          'long' => 250,
          'requerido' => true,
          'uppercase' => true
        ],
        'aMaterno' => [
          'nombre' => 'Apellido materno',
          'tipo' => 'string',
          'minLong' => 3,
          'long' => 250,
          'requerido' => true,
          'uppercase' => true
        ],
        'rfcProveedor' => [
          'nombre' => 'Registro Federal del Contribuyente (Apoderado)',
          'tipo' => 'rfc',
          'long' => 13,
          'requerido' => false,
          'uppercase' => true
        ],
        'documents' => [
          'nombre' => 'Sección de documentos',
          'tipo' => 'upload',
          'long' => 100,
          'requerido' => false,
          'th' => [
            'Título del documento',
            'Nombre del documento',
          ]
        ]
      ]
    ],
    'requisicion'=>[
      'name'=>'Requisición',
      'tipo'=>'container',
      'type'=>['prensa','radio', 'television', 'revista', 'internet', 'monitoreo', 'spot', 'filmacion', 'eventosJG', 'cineminuto', 'otro'],
      'upload'=>true,
      'data'=>[
        'requisicion'=>[
          'nombre'=>'Requisición',
          'tipo'=>'upload',
          'long'=>100,
          'requerido'=>true,
          'th'=>[
            'Título del documento',
            'Nombre del documento',
          ]
        ],
        'autorizacion'=>[
          'nombre'=>'Autorización',
          'tipo'=>'upload',
          'long'=>100,
          'requerido'=>true,
          'th'=>[
            'Título del documento',
            'Nombre del documento',
          ]
        ]        
      ]
    ],
    'invitacion'=>[
      'name'=>'Invitacion',
      'tipo'=>'container',
      'type'=>['prensa','radio', 'television', 'revista', 'internet', 'monitoreo', 'spot', 'filmacion', 'eventosJG', 'cineminuto', 'otro'],
      'upload'=>true,
      'data'=>[
        'nomComision'=>[
          'encabezado'=>'Datos',
          'nombre'=>'Nombre de la Comisión',
          'tipo'=>'string',
          'long'=>200,
          'requerido'=>true
        ],
        'orgEvento'=>[
          'nombre'=>'Organizador del Evento',
          'tipo'=>'string',
          'long'=>100,
          'requerido'=>true
        ],
        'link'=>[
          'nombre'=>'Link del Evento (opcional)',
          'tipo'=>'url',
          'long'=>200,
          'requerido'=>false
        ],
        'motivo'=>[
          'nombre'=>'Motivo de la Comisión',
          'tipo'=>'textarea',
          'long'=>1600,
          'requerido'=>true
        ],
        'documents'=>[
          'nombre'=>'Sección de documentos',
          'tipo'=>'upload',
          'long'=>100,
          'requerido'=>true,
          'th'=>[
            'Título del documento',
            'Nombre del documento',
          ],
        ]
      ]
    ]   
  ];

  /**
   *  obtieneFasesFSVTE
   *
   *  Mapear fases para barra lateral
   *
   *  Entrega nombres de las fases definidas en el modelo para construir en la vista
   *  los elementos en la barra lateral
   *
   *  @package   comsoc.app.StaticContent
   *  @author    Carlos González Armenta <cgonzaleza@cdmx.gob.mx>
   *  @copyright Oficialia Mayor de la Ciudad de México
   *         Dirección General de Gobernabilidad de Tecnologías de Información y Comunicaciones
   *
   *  @global    Array const FASES
   *  @param     Sting $id fase actual para poder indicar cual es la activa
   *  @return    Collection mapeo de fases para presentación de la vista
   *  @since     Versión 1.0,  revisión 2016-09-09
   *  @version   1.0
   *  @access    public
   *
  */
    public static function obtieneFasesFSVTE($id){
      return collect(SELF::FASES)->map(function($i,$k) use($id){
        $array = ['id'=>$k,
                  'nombre'=>$i['name'],
                  'upload'=>(isset($i['upload']))?$i['upload']:false,
                  'array'=>(isset($i['array']))?$i['array']:false,
                  'tableDisplay'=>(isset($i['tableDisplay']))?$i['tableDisplay']:false,
                  'addItemLabel'=>(isset($i['addItemLabel']))?$i['addItemLabel']:false,
                  'dynamicField'=>(isset($i['dynamicField']))?$i['dynamicField']:false,
                  'type'=>(isset($i['type']))?$i['type']:false
                 ];
        if($k === $id)  $array['active']=true;
        return $array;
      });
    }

    public static function obtieneDefinicionFSVTE(){ 
      $obj = new self();
      // dd(\Session::get('faseActual'));
      return collect(SELF::FASES[\Session::get('faseActual')]['data'])->map(function($i,$k) use($obj){
        if($i['tipo'] == 'select'){
          switch($i['src']['tipo']){
            case 'mule':
                $muleContainer = (isset($i['src']['container']))?$i['src']['container']:null;
                if(!isset($i['src']['id'])) $i['src']['id'] = 'descripcion';
                if(!isset($i['src']['descripcion'])) $i['src']['descripcion'] = 'descripcion';
                $i['datos'] = $obj->obtieneCatalogo($i['src']['type'],$i['src']['method'],$i['src']['port'],$i['src']['parameters'],$i['src']['id'],$i['src']['descripcion'],$muleContainer);
                break;
            case 'dynamic':
                $i['datos'] = ['Datos no cargados'];
                break;
            case 'static':
                if(!isset($i['src']['id'])) $i['src']['id'] = 'descripcion';
                switch($i['src']['id']){
                    case 'descripcion':
                        $i['datos'] = collect($i['datos'])->flatMap(function($i){
                            return [$i=>$i];
                        });
                        break;
                    case 'boolean':
                        $i['datos'] = ['true'=>'Sí','false'=>'No'];
                        break;
                }
                /*if(isset($i['src']['id']) && $i['src']['id'] == 'descripcion'){
                    $i['datos'] = collect($i['datos'])->flatMap(function($i){
                        return [$i=>$i];
                    });
                }*/
                break;
            case 'session':
                if(isset($i['action'])){
                    switch($i['action']){
                        case 'count':
                            $count = count(\Session::get($i['src']['variable']));
                            $i['datos'] = [$count=>$count];
                    }
                }else{
                    $choice = \Session::get($i['src']['variable']);
                    switch($choice){
                        case 'false':
                            $choice = 'No';
                            break;
                        case 'true':
                            $choice = 'Sí';
                            break;
                    }
                    
                    $i['datos'] = [\Session::get($i['src']['variable'])=>$choice];
                }
                break;
            case 'sessionArray':
                $display = explode('.',$i['src']['display']);
                $idValue = (isset($i['src']['idValue']))?$i['src']['idValue']:$display;
                $i['datos'] = collect(\Session::get('fase.'.$i['src']['variable']))->flatMap(function($i) use($display,$idValue){
                        return [' '.$i[$idValue]=>$i[$display[0]][$display[1]][$display[2]][$display[3]]]; 
                    });
                break;
          }
        }
        if($i['tipo']=='container'){
          $i['detalle'] = collect($i['detalle'])->map(function($j,$kJ) use($obj){
            if(isset($j['src'])){
                switch($j['src']['tipo']){
                    case 'mule':
                        $muleContainer = (isset($j['src']['container']))?$j['src']['container']:null;
                        if(!isset($j['src']['id'])) $j['src']['id'] = 'descripcion';
                        if(!isset($j['src']['descripcion'])) $j['src']['descripcion'] = 'descripcion';
                        $j['datos'] = $obj->obtieneCatalogo($j['src']['type'],$j['src']['method'],$j['src']['port'],$j['src']['parameters'],$j['src']['id'],$j['src']['descripcion'],$muleContainer);
                        break;
                    case 'static':
                        if(!isset($j['src']['id'])) $j['src']['id'] = 'descripcion';
                        switch($j['src']['id']){
                            case 'descripcion':
                                $j['datos'] = collect($j['datos'])->flatMap(function($i){
                                    return [$i=>$i];
                                });
                                break;
                            case 'boolean':
                                $j['datos'] = ['true'=>'Sí','false'=>'No'];
                                break;
                        }
                        /*if(isset($j['src']['id']) && $j['src']['id'] == 'descripcion'){
                            $j['datos'] = collect($j['datos'])->flatMap(function($v){
                                return [$v=>$v];
                            }); 
                        }*/
                        break;
                    case 'session':
                        $j['datos'] = [\Session::get($j['src']['variable'])=>\Session::get($j['src']['variable'])];
                        break;
                    case 'sessionArray':
                        $display = explode('.',$j['src']['display']);
                        $j['datos'] = collect(\Session::get('fase.'.$j['src']['variable']))->flatMap(function($i) use($display){ 
                                switch(count($display)){
                                    case 1:
                                        return [$i[$display[0]]=>$i[$display[0]]];
                                    case 2:
                                        return [$i[$display[0]][$display[1]]=>$i[$display[0]][$display[1]]]; 
                                }
                            });
                        break;
                    
                }
                return $j;
            }else{
              return $j;
            }
          });
        }
        // dd($i);
        return $i;
      });
    }
    
    public static function existeFase($fase){
      return array_key_exists($fase,SELF::FASES);
    }

    public static function obtieneDetalleFSVTE($fase,$variable){
        $obj = new self();
        $variable = explode('.',$variable);
        
        switch(count($variable)){
            case 1:
                $definicion = SELF::FASES[$fase]['data'][$variable[0]]['detalle'];
                break;
            case 2:
                $definicion = SELF::FASES[$fase]['data'][$variable[0]]['detalle'][$variable[1]]['detalle'];
                break;
            case 3:
                $definicion = SELF::FASES[$fase]['data'][$variable[0]]['detalle'][$variable[2]]['detalle'];
                break;
        }
        //dd($definicion);
        return collect($definicion)->map(function($i) use($obj){
            if(isset($i['src'])){
                switch($i['src']['tipo']){
                    case 'mule':
                        $muleContainer = (isset($i['src']['container']))?$i['src']['container']:null;
                        if(!isset($i['src']['id'])) $i['src']['id'] = 'descripcion';
                        if(!isset($i['src']['descripcion'])) $i['src']['descripcion'] = 'descripcion';
                        $i['datos'] = $obj->obtieneCatalogo($i['src']['type'],$i['src']['method'],$i['src']['port'],$i['src']['parameters'],$i['src']['id'],$i['src']['descripcion'],$muleContainer);
                        break;
                    case 'dynamic':
                        $i['datos'] = ['Datos no cargados'];
                        break;
                    case 'static':
                        if(!isset($i['src']['id'])) $i['src']['id'] = 'descripcion';
                        switch($i['src']['id']){
                            case 'descripcion':
                                $i['datos'] = collect($i['datos'])->flatMap(function($i){
                                    return [$i=>$i];
                                });
                                break;
                            case 'boolean':
                                $i['datos'] = ['true'=>'Sí','false'=>'No'];
                                break;
                        }

                        /*if(!isset($i['src']['id']) || $i['src']['id'] == 'descripcion'){
                            $i['datos'] = collect($i['datos'])->flatMap(function($j){
                                return [$j=>$j];
                            });
                        }*/
                        break;
                    case 'session':
                        $i['datos'] = [\Session::get($i['src']['variable'])=>\Session::get($i['src']['variable'])];
                        break;
                    case 'sessionArray':
                        $display = explode('.',$i['src']['display']);
                        $i['datos'] = collect(\Session::get('fase.'.$i['src']['variable']))->flatMap(function($i) use($display){ 
                                switch(count($display)){
                                    case 1:
                                        return [$i[$display[0]]=>$i[$display[0]]];
                                    case 2:
                                        return [$i[$display[0]][$display[1]]=>$i[$display[0]][$display[1]]]; 
                                }
                            });
                        break;
                }
                return $i;
            }else{
                return $i;
            }
        });
    }

    private function obtieneCatalogo($type,$method,$port,$parameters,$id,$descripcion='descripcion',$container = null){
        $util = new \App\Http\Controllers\Utilidades();
        
        $parametros = ['data'=>$parameters];
        if(isset($parametros['data']['valores']['anio'])){  
            $parametros['data']['valores']['anio'] = (int)eval('return '.$parametros['data']['valores']['anio'] .';' );
        }
        //dd($parametros);
        $retorno = $util->muleConnection($type,$method,$port,$parametros);
        if(!is_null($container)){ 
            $data=[];
            collect($retorno['data'])->each(function($i) use($container,&$data){ 
                foreach($i[$container] as $j){
                    $data[]=$j;
                }
            });
        }else{
            $data = $retorno['data'];
        }
        return collect($data)->filter(function($i){
            return $i;
            return $i['activo'] == true;
        })->flatMap(function($i) use($id,$descripcion){ 
         //dd($descripcion);
            return [$i[$id]=>$i[$descripcion]];
        })->sort()->prepend('Seleccione');
    }

    public static function obtieneDefinicionFases(){
        return collect(SELF::FASES)->filter(function($i,$k){ return $k != 'firmaelectronica';});
    }
}

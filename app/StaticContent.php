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
        // 'datosEmpresa' =>[
        //   'tipo' => 'container',
        //   'long' => 100,
        //   'requerido' => true,
        //   'unico' => true,
        //   'detalle' => [
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
          // ]
        // ],
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
    'requisicion'=>[
      'name'=>'Requisición',
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
    // 'registroPersonalNacional'=>[
    //   'name'=> 'Registro de Personal Comisionado',
    //   'array'=>true,
    //   'type' => ['nacional'],
    //   'addItemLabel'=>'Comisionados Nacionales',
    //   'tableDisplay'=>'comisionados.nombres.paterno.materno',
    //   'data' => [
    //     'genero'=>[
    //       'nombre'=>'Genero',
    //       'tipo'=>'select',
    //       'src'=>[
    //         'tipo'=>'static',
    //         'id'=>'descripcion'
    //       ],
    //       'datos'=>['Masculino','Femenino'],
    //       'long'=>100,
    //       'requerido'=>true
    //     ],
    //     'nombres'=>[
    //       'nombre'=>'Nombre(s)',
    //       'tipo'=>'string',
    //       'long'=>200,
    //       'requerido'=>true
    //     ],
    //     'paterno'=>[
    //       'nombre'=>'Apellido paterno',
    //       'tipo'=>'string',
    //       'long'=>200,
    //       'requerido'=>true
    //     ],
    //     'materno'=>[
    //       'nombre'=>'Apellido materno',
    //       'tipo'=>'string',
    //       'long'=>200,
    //       'requerido'=>true
    //     ],
    //     'mail'=>[
    //       'nombre'=>'Correo electrónico (de preferencia correo institucional)',
    //       'tipo'=>'mail',
    //       'long'=>200,
    //       'requerido'=>true
    //     ],
    //     'tipoIntegrante'=>[
    //       'nombre'=>'Tipo de integrante del sujeto obligado',
    //       'tipo'=>'select',
    //       'src'=>[
    //         'tipo'=>'static',
    //         'id'=>'descripcion'
    //       ],
    //       'datos'=>['Confianza', 'Honorarios', 'Otro'],
    //       'long'=>100,
    //       'requerido'=>false
    //     ],        
    //     'numeroEmpleado'=>[
    //       'nombre'=>'Número de empleado',
    //       'tipo'=>'number',
    //       'long'=>10,
    //       'minLong'=>4,
    //       'requerido'=>false
    //     ],
    //     'denominacionCargo'=>[
    //       'nombre'=>'Denominación del cargo (De conformidad con el nombramiento otorgado)',
    //       'tipo'=>'string',
    //       'long'=>200,
    //       'requerido'=>false
    //     ],
    //     'nivelPuesto'=>[
    //       'nombre'=>'Nivel de puesto (Nomenclatura numérica)',
    //       'tipo'=>'number',
    //       'long'=>200,
    //       'requerido'=>false
    //     ],
    //     'areaAdscripcion'=>[
    //       'nombre'=>'Area de Adscripción o Unidad Administrativa',
    //       'tipo'=>'string',
    //       'long'=>400,
    //       'requerido'=>true
    //     ],
    //     'objetivoComisionado'=>[
    //       'nombre'=>'Objetivo del comisionado',
    //       'tipo'=>'textarea',
    //       'long'=>1500,
    //       'requerido'=>false
    //     ],
    //     'actividadesRealizar'=>[
    //       'nombre'=>'Actividades a realizar',
    //       'tipo'=>'textarea',
    //       'long'=>1500,
    //       'requerido'=>false
    //     ],
    //     'viajeViaticos'=>[
    //       'nombre'=>'Financiado',
    //       'tipo'=>'select',
    //       'src'=>[
    //         'tipo'=>'static',
    //         'id'=>'descripcion'
    //       ],
    //       'datos'=>['No','Parcial sólo Pasajes','Parcial sólo Viáticos','Parcial Viáticos y Pasajes','Total'],
    //       'long'=>100,
    //       'requerido'=>false
    //     ],
    //     'pasajes'=>[
    //       'nombre' => 'pasajes',
    //       'tipo'=>'container',
    //       'long'=>100,
    //       'requerido'=>false,
    //       'unico'=>false,
    //       'th'=>[
    //         'Pasajes (De acuerdo a la partida que corresponda)',
    //         'Ingrese monto de pasajes'
    //       ],
    //       'encabezado'=>'Monto de Pasajes',
    //       'detalle'=>[
    //         'pasajesPartida'=>[
    //           'nombre'=>'Pasajes',
    //           'tipo'=>'select',
    //           'src'=>[
    //             'tipo'=>'static',
    //             'id'=>'descripcion'
    //           ],
    //           'datos'=>['3711 - Pasajes aéreos nacionales', '3721 - Pasajes terrestres nacionales', '3722 - Pasajes terrestres al interior del Distrito Federal', '3723 - Traslado terrestre de personas'],
    //           'long'=>100,
    //           'requerido'=>false
    //         ],
    //         'montoPasajes'=>[
    //           'tipo'=>'double',
    //           'long'=>100,
    //           'requerido'=>true
    //         ] 
    //       ]
    //     ],
    //     'viaticos'=>[
    //       'nombre' => 'viaticos',
    //       'tipo'=>'container',
    //       'long'=>100,
    //       'requerido'=>false,
    //       'unico'=>false,
    //       'th'=>[
    //         'Pasajes (De acuerdo a la partida que corresponda)',
    //         'Ingrese monto de viáticos'
    //       ],
    //       'encabezado'=>'Monto de Viáticos',
    //       'detalle'=>[
    //         'viaticosPartida'=>[
    //           'nombre'=>'Viáticos',
    //           'tipo'=>'select',
    //           'src'=>[
    //             'tipo'=>'static',
    //             'id'=>'descripcion'
    //           ],
    //           'datos'=>['3751 - Viáticos en el país', '3781 - Servicios integrales de traslado y viáticos', '3791 - Otros servicios de traslado y hospedaje'],
    //           'long'=>100,
    //           'requerido'=>false
    //         ],
    //         'montoViaticos'=>[
    //           'tipo'=>'double',
    //           'long'=>100,
    //           'requerido'=>true
    //         ] 
    //       ]
    //     ],        
    //     'descripcionViatico'=>[
    //       'nombre'=>'Descripcion de Viáticos',
    //       'tipo'=>'textarea',
    //       'long'=>1500,
    //       'requerido'=>false
    //     ],
    //     'idaVuelta'=>[
    //       'nombre'=>'Ida y Vuelta',
    //       'tipo'=>'select',
    //       'src'=>[
    //         'tipo'=>'static',
    //         'id'=>'descripcion'
    //       ],
    //       'datos'=>['Si','No'],
    //       'long'=>100,
    //       'requerido'=>false
    //     ],
    //     'saliendoEstadoNacional'=>[
    //       'nombre'=>'Saliendo de (Estado)',
    //       'tipo'=>'select',
    //        'src'=>[
    //         'tipo'=>'static',
    //         'id'=>'saliendoEstadoNacional'
    //       ],
    //       'datos'=>[],
    //       'long'=>100,
    //       'requerido'=>false
    //     ],
    //     'saliendoMunicipioNacional'=>[
    //       'nombre'=>'Saliendo de (Municipio)',
    //       'tipo'=>'select',
    //        'src'=>[
    //         'tipo'=>'static',
    //         'id'=>'saliendoMunicipioNacional'
    //       ],
    //       'datos'=>[],
    //       'long'=>100,
    //       'requerido'=>false
    //     ],            
    //     'llegandoEstadoNacional'=>[
    //       'nombre'=>'Llegando a (Estado)',
    //       'tipo'=>'select',
    //        'src'=>[
    //         'tipo'=>'static',
    //         'id'=>'llegandoEstadoNacional'
    //       ],
    //       'datos'=>[],
    //       'long'=>100,
    //       'requerido'=>false
    //     ],            
    //     'llegandoMunicipioNacional'=>[
    //       'nombre'=>'Llegando a (Municipio)',
    //       'tipo'=>'select',
    //        'src'=>[
    //         'tipo'=>'static',
    //         'id'=>'llegandoMunicipioNacional'
    //       ],
    //       'datos'=>[],
    //       'long'=>100,
    //       'requerido'=>false
    //     ],
    //     'dateSalida'=>[
    //       'nombre'=>'Fecha de salida',
    //       'tipo'=>'date',
    //       'long'=>1500,
    //       'format'=>'c',
    //       'requerido'=>true,
    //       'requiereAlmacenar'=>'_dateSalida'
    //     ],
    //     'dateRegreso'=>[
    //       'nombre'=>'Fecha de regreso',
    //       'tipo'=>'date',
    //       'long'=>1500,
    //       'format'=>'c',
    //       'requerido'=>true,
    //       'requiereValidar'=>'_dateSalida'
    //     ]
    //   ]
    // ],    
    // 'registroPersonalInternacional'=>[
    //   'name'=>'Registro de Personal Comisionado',
    //   'array'=>true,
    //   'type' => ['internacional'],
    //   'addItemLabel'=>'Comisionados Internacionales',
    //   'tableDisplay'=>'comisionados.nombres.paterno.materno',
    //   'data' => [
    //     'genero'=>[
    //       'nombre'=>'Género',
    //       'tipo'=>'select',
    //       'src'=>[
    //         'tipo'=>'static',
    //         'id'=>'descripcion'
    //       ],
    //       'datos'=>['Masculino','Femenino'],
    //       'long'=>100,
    //       'requerido'=>true
    //     ],
    //     'nombres'=>[
    //       'nombre'=>'Nombre(s)',
    //       'tipo'=>'string',
    //       'long'=>200,
    //       'requerido'=>true
    //     ],
    //     'paterno'=>[
    //       'nombre'=>'Apellido paterno',
    //       'tipo'=>'string',
    //       'long'=>200,
    //       'requerido'=>true
    //     ],
    //     'materno'=>[
    //       'nombre'=>'Apellido materno',
    //       'tipo'=>'string',
    //       'long'=>200,
    //       'requerido'=>true
    //     ],
    //     'mail'=>[
    //       'nombre'=>'Correo electrónico (de preferencia correo institucional)',
    //       'tipo'=>'mail',
    //       'long'=>200,
    //       'requerido'=>true
    //     ],
    //     'tipoIntegrante'=>[
    //       'nombre'=>'Tipo de integrante del sujeto obligado',
    //       'tipo'=>'select',
    //       'src'=>[
    //         'tipo'=>'static',
    //         'id'=>'descripcion'
    //       ],
    //       'datos'=>['Confianza', 'Honorarios', 'Otro'],
    //       'long'=>100,
    //       'requerido'=>false
    //     ],        
    //     'numeroEmpleado'=>[
    //       'nombre'=>'Número de empleado',
    //       'tipo'=>'number',
    //       'long'=>10,
    //       'minLong'=>4,
    //       'requerido'=>false
    //     ],
    //     'denominacionCargo'=>[
    //       'nombre'=>'Denominación del cargo (De conformidad con el nombramiento otorgado)',
    //       'tipo'=>'string',
    //       'long'=>200,
    //       'requerido'=>false
    //     ],
    //     'nivelPuesto'=>[
    //       'nombre'=>'Nivel de puesto (Nomenclatura numérica)',
    //       'tipo'=>'number',
    //       'long'=>200,
    //       'requerido'=>false
    //     ],
    //     'areaAdscripcion'=>[
    //       'nombre'=>'Area de Adscripción o Unidad Administrativa',
    //       'tipo'=>'string',
    //       'long'=>400,
    //       'requerido'=>true
    //     ],
    //     'objetivoComisionado'=>[
    //       'nombre'=>'Objetivo del comisionado',
    //       'tipo'=>'textarea',
    //       'long'=>1500,
    //       'requerido'=>false
    //     ],
    //     'actividadesRealizar'=>[
    //       'nombre'=>'Actividades a realizar',
    //       'tipo'=>'textarea',
    //       'long'=>1500,
    //       'requerido'=>false
    //     ],
    //     'viajeViaticos'=>[
    //       'nombre'=>'Financiado',
    //       'tipo'=>'select',
    //       'src'=>[
    //         'tipo'=>'static',
    //         'id'=>'descripcion'
    //       ],
    //       'datos'=>['No','Parcial sólo Pasajes','Parcial sólo Viáticos','Parcial Viáticos y Pasajes','Total'],
    //       'long'=>100,
    //       'requerido'=>false
    //     ],
    //     'pasajes'=>[
    //       'nombre' => 'pasajes',
    //       'tipo'=>'container',
    //       'long'=>100,
    //       'requerido'=>false,
    //       'unico'=>false,
    //       'th'=>[
    //         'Pasajes (De acuerdo a la partida que corresponda)',
    //         'Ingrese monto de pasajes'
    //       ],
    //       'encabezado'=>'Monto de Pasajes',
    //       'detalle'=>[
    //         'pasajesPartida'=>[
    //           'nombre'=>'Pasajes',
    //           'tipo'=>'select',
    //           'src'=>[
    //             'tipo'=>'static',
    //             'id'=>'descripcion'
    //           ],
    //           'datos'=>['3711 - Pasajes aéreos nacionales', '3712 - Pasajes aéreos internacionales', '3721 - Pasajes terrestres nacionales', '3722 - Pasajes terrestres al interior del Distrito Federal', '3723 - Traslado terrestre de personas', '3724 - Pasajes terrestres internacionales'],
    //           'long'=>100,
    //           'requerido'=>false
    //         ],
    //         'montoPasajes'=>[
    //           'tipo'=>'double',
    //           'long'=>100,
    //           'requerido'=>true
    //         ] 
    //       ]
    //     ],
    //     'viaticos'=>[
    //       'nombre' => 'viaticos',
    //       'tipo'=>'container',
    //       'long'=>100,
    //       'requerido'=>false,
    //       'unico'=>false,
    //       'th'=>[
    //         'Pasajes (De acuerdo a la partida que corresponda)',
    //         'Ingrese monto de viáticos'
    //       ],
    //       'encabezado'=>'Monto de Viáticos',
    //       'detalle'=>[
    //         'viaticosPartida'=>[
    //           'nombre'=>'Viáticos',
    //           'tipo'=>'select',
    //           'src'=>[
    //             'tipo'=>'static',
    //             'id'=>'descripcion'
    //           ],
    //           'datos'=>['3751 - Viáticos en el país', '3761 - Viáticos en el extranjero', '3781 - Servicios integrales de traslado y viáticos', '3791 - Otros servicios de traslado y hospedaje'],
    //           'long'=>100,
    //           'requerido'=>false
    //         ],
    //         'montoViaticos'=>[
    //           'tipo'=>'double',
    //           'long'=>100,
    //           'requerido'=>true
    //         ] 
    //       ]
    //     ],        
    //     'descripcionViatico'=>[
    //       'nombre'=>'Descripcion de Viáticos',
    //       'tipo'=>'textarea',
    //       'long'=>1500,
    //       'requerido'=>false
    //     ],
    //     'idaVuelta'=>[
    //       'nombre'=>'Ida y Vuelta',
    //       'tipo'=>'select',
    //       'src'=>[
    //         'tipo'=>'static',
    //         'id'=>'descripcion'
    //       ],
    //       'datos'=>['Si','No'],
    //       'long'=>100,
    //       'requerido'=>false
    //     ],
    //     'saliendoContinenteInternacional'=>[
    //       'nombre'=>'Saliendo de (Continente)',
    //       'tipo'=>'select',
    //       'src'=>[
    //         'tipo'=>'static',
    //         'id'=>'descripcion'
    //       ],
    //       // 'datos'=>['América', 'África', 'Asia', 'Europa', 'Oceanía'],
    //       'datos'=>['América', 'África', 'Asia', 'Europa'],
    //       'long'=>100,
    //       'requerido'=>false
    //     ],
    //     'saliendoPaisInternacional'=>[
    //       'nombre'=>'Saliendo de (País)',
    //       'tipo'=>'select',
    //        'src'=>[
    //         'tipo'=>'static',
    //         'id'=>'saliendoPaisInternacional'
    //       ],
    //       'datos'=>[],
    //       'long'=>100,
    //       'requerido'=>false
    //     ],
    //     'saliendoEntidadInternacional'=>[
    //       'nombre'=>'Saliendo de (Ciudad)',
    //       'tipo'=>'select',
    //        'src'=>[
    //         'tipo'=>'static',
    //         'id'=>'saliendoEntidadInternacional'
    //       ],
    //       'datos'=>[],
    //       'long'=>100,
    //       'requerido'=>false
    //     ],
    //     'llegandoContinenteInternacional'=>[
    //       'nombre'=>'Llegando a (Continente)',
    //       'tipo'=>'select',
    //       'src'=>[
    //         'tipo'=>'static',
    //         'id'=>'descripcion'
    //       ],
    //       // 'datos'=>['América', 'África', 'Asia', 'Europa', 'Oceanía'],          
    //       'datos'=>['América', 'África', 'Asia', 'Europa'],
    //       'long'=>100,
    //       'requerido'=>false
    //     ],               
    //     'llegandoPaisInternacional'=>[
    //       'nombre'=>'Llegando a (País)',
    //       'tipo'=>'select',
    //       'src'=>[
    //         'tipo'=>'static',
    //         'id'=>'descripcion'
    //       ],
    //       'datos'=>[],
    //       'long'=>100,
    //       'requerido'=>false
    //     ],            
    //     'llegandoEntidadInternacional'=>[
    //       'nombre'=>'Llegando a (Ciudad)',
    //       'tipo'=>'select',
    //        'src'=>[
    //         'tipo'=>'static',
    //         'id'=>'descripcion'
    //       ],
    //       'datos'=>[],
    //       'long'=>100,
    //       'requerido'=>false
    //     ],
    //     'dateSalida'=>[
    //       'nombre'=>'Fecha de salida',
    //       'tipo'=>'date',
    //       'long'=>1500,
    //       'format'=>'c',
    //       'requerido'=>true,
    //       'requiereAlmacenar'=>'_dateSalida'
    //     ],
    //     'dateRegreso'=>[
    //       'nombre'=>'Fecha de regreso',
    //       'tipo'=>'date',
    //       'long'=>1500,
    //       'format'=>'c',
    //       'requerido'=>true,
    //       'requiereValidar'=>'_dateSalida'
    //     ]
    //   ]
    // ]    
  ];


  /**
   *  obtieneFasesFSVTE
   *
   *  Mapear fases para barra lateral
   *
   *  Entrega nombres de las fases definidas en el modelo para construir en la vista
   *  los elementos en la barra lateral
   *
   *  @package   Dictaminacion.App.StaticContent
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
      // dd([\Session::get('faseActual')]);
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

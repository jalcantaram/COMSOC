@extends('templates.master')
@section('titulo','CDMX | Sistema de CGCS')

@section('head')
    <link rel="stylesheet" href="{!! asset('assets/css/font-awesome/css/font-awesome.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/bootstrap/dataTables.bootstrap.min.css') !!}">
@endsection

@section('nav2')
  @include('templates.nav2',['nav2'=> [ 
      ['nombre'=>'&laquo; Regresar', 'href'=> url(\URL::previous())],
    ]
  ])
@endsection

@section('container')
<div class="divGeneral">
  <div class="forminfo">
    @if($datos['data']['status'] == 'captura')
      <h3><center><strong>Validar Viático</strong></center></h3>
    @elseif($datos['data']['status'] == 'firmaTitular')
      <h3><center><strong>Detalle del Viático</strong></center></h3>
    @elseif($datos['data']['status'] == 'firmaDGA')
      <h3><center><strong>Validar Viático</strong></center></h3>
    @elseif($datos['data']['status'] == 'Autorizado')
      <h3><center><strong>Validar Viático</strong></center></h3>
    @elseif($datos['data']['status'] == 'rechazadoTitular')
      <h3><center><strong>Detalle del Viático</strong></center></h3>
    @elseif($datos['data']['status'] == 'rechazadoDGA')
      <h3><center><strong>Detalle del Viático</strong></center></h3>
    @endif 
    <br>
    @if(($datos['data']['status'] != 'rechazadoTitular' && $datos['data']['status'] != 'Autorizado') || ($datos['data']['status'] == 'firmaTitular'))
      @if(!Session::has('firmaactiva'))
        <div class="row">
          <div class="col-md-4 col-md-offset-4"></div>
          <div class="col-md-2 col-md-offset-2">
            <a data-toggle="modal" data-target="#activaFirma" href="" class="add" data-toggle="tooltip" data-placement="top" title="Los datos proporcionados para la firma electrónica permanecerán temporalmente almacenados en su equipo, por lo que al salir de Gobierno Digital CDMX y/o actualizar la página, dichos datos se eliminarán automáticamente." style="float: right;"><i class="espaciadoAcciones fa fa-unlock  fa-lg" align="right" ></i>Activar Firma</a>
          </div>
        </div>
        <div class="modal fade" id="activaFirma" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Ingresa tus archivos</h4>
              </div>
              <div class="modal-body" style="color:#000;text-align: left;">
                <form id="formGuardafirma" action="{{ url('/setFirmainsidePage') }}" enctype="multipart/form-data" accept-charset="UTF-8" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                  <div class="col-lg-12">
                    <label for="cer">Seleccione el archivo .cer</label>     
                  </div>
                  <div class="col-lg-12 espaciado">
                    <div class="col-lg-4">
                      <a class="btn btn-primary  btn-file">
                        Selecciona archivo
                        <input accept=".cer" type="file" name="cer" id="cer" required="required" onchange="$('#upload-cert').html($(this).val());">
                      </a>
                    </div>
                    <div class="col-lg-8">
                      <span class="label label-default upload-span" id="upload-cert">&nbsp;</span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-lg-12">
                  <br>
                    <label for="key">Seleccione el archivo .key</label>
                  </div>
                  <div class="col-lg-12 espaciado">
                    <div class="col-lg-4">
                      <a class="btn btn-primary btn-file">
                        Selecciona archivo
                        <input accept=".key" type="file" name="key" id="key" required="required" onchange="$('#upload-key').html($(this).val());">
                      </a>
                    </div>
                    <div class="col-lg-8">
                      <span class="label label-default upload-span" id="upload-key">&nbsp;</span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-lg-12">
                  <br>
                    <label for="password">Ingresa la contraseña de tu fiel</label>
                  </div>
                  <div class="col-lg-12 espaciado">
                    <input class="form-control" type="password" name="password" placeholder="Contraseña" required="required">
                    <br>
                  </div>
                </div>
                <button type="submit" class="btn btn-secondary btncdmx">Guardar</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      @else
        <div class="row">
          <div class="col-md-3 col-md-offset-3"></div>
          <div class="col-md-3 col-md-offset-3">
            <form action="{{ url('/forgetFirma')}}" method="post" id="forgetFirma" style="float: right;">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <a href="javascript:{}" class="add" onclick="document.getElementById('forgetFirma').submit(); return false;"><i class="espaciadoAcciones fa fa fa-lock  fa-lg" aria-hidden="true"></i>Desactivar Firma</a>
            </form>
          </div>
        </div>  
      @endif
    @endif
    <h4>
      <span><strong>Folio: </strong></span><span style="text-transform: capitalize;"> @if (isset($datos['data']['folio'])) {{ $datos['data']['folio'] }} @else <span>Este dato no esta registrado</span> @endif</span>
    </h4>
    <h4>
      <span><strong>Estatus del Viático: </strong></span>
      @if(isset($datos['data']['status']))
        @if($datos['data']['status'] == 'captura')
          <span>En Proceso de Captura</span>
        @elseif($datos['data']['status'] == 'firmaTitular')
          <span>En Firma del Titular</span>
        @elseif($datos['data']['status'] == 'firmaDGA')
          <span>En Firma del DGA</span>
        @elseif($datos['data']['status'] == 'Autorizado')
          <span>Viático Autorizado</span>
        @elseif($datos['data']['status'] == 'rechazadoTitular')
          <span>Rechazado por el Titular</span>
        @elseif($datos['data']['status'] == 'rechazadoDGA')
          <span>Rechazado por la DGA</span>
        @endif           
      @endif
    </h4>
    <br>
    <div class="panel-group" id="accordion1">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion1" href="#collapseOne">Detalle de la Comisión</a></h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in">
          <div class="panel-body">
            <strong>Nombre de la Comision:</strong>
              @if(isset($datos['data']['detalleComision']['nomComision']))
                 {{ $datos['data']['detalleComision']['nomComision'] }}
              @else
                <p>Este dato no esta registrado</p>
              @endif
              <br><br>
            <strong>Organizador del Evento:</strong>
              @if(isset($datos['data']['detalleComision']['orgEvento']))
                {{ $datos['data']['detalleComision']['orgEvento'] }}
              @else
                <p>Este dato no esta registrado</p>
              @endif
              <br><br>
            <strong>Link del Evento:</strong>
              @if(isset($datos['data']['detalleComision']['link']))
                {{ $datos['data']['detalleComision']['link'] }}
              @else
                <p>Este dato no esta registrado</p>
              @endif
              <br><br>
            <strong>Motivo de la Comisión:</strong>
              @if(isset($datos['data']['detalleComision']['motivo']))
                {{ $datos['data']['detalleComision']['motivo'] }}
              @else
                <p>Este dato no esta registrado</p>
              @endif
              <br><br>
            <table id="fichas" class="table table-striped" cellspacing="0" width="100%">
              <strong>Documento(s) Adjunto(s):</strong>
                <thead>
                  <th>Nombre del documento</th>
                  <th>Link del documento</th>
                </thead>
                <tbody>
                  @if (isset($datos['data']['detalleComision']['documents']))
                    @foreach ($datos['data']['detalleComision']['documents'] as $key => $item)
                    <tr>
                      <td>
                        @if(isset($item['nombreDocumento']))
                           {{ $item['nombreDocumento']}}
                        @else
                           <p>Este dato no esta registrado</p>
                        @endif
                      </td>
                      <td>
                        @if(isset($item['url']))
                          <a href="{{ $item['url'] }}" target="_blank">{{ $item['nombreDocumento'] }}</a>
                        @else
                          <p>Este dato no esta registrado</p>
                        @endif
                      </td>
                    </tr>
                    @endforeach
                  @endif
                </tbody>
            </table>
            <br>
            @if($datos['data']['status'] == 'rechazadoTitular' || $datos['data']['status'] == 'firmaTitular' || $datos['data']['status'] == 'rechazadoDGA')
              @if(isset($datos['data']['detalleComision']['observacionesTitular']))
                <div class="row">
                  <div class="col-md-12">
                    <h4><strong>Observaciones del Detalle de la Comisión (Titular):</strong></h4>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <textarea class="form-control" rows="5" id="comment" disabled="disabled">{{ $datos['data']['detalleComision']['observacionesTitular'] }}</textarea>
                    </div>
                  </div>
                </div>
              @endif
              @if(isset($datos['data']['detalleComision']['observacionesDGA']))
                <div class="row">
                  <div class="col-md-12">
                    <h4><strong>Observaciones del Detalle de la Comisión (DGA):</strong></h4>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <textarea class="form-control" rows="5" id="comment" disabled="disabled">{{ $datos['data']['detalleComision']['observacionesDGA'] }}</textarea>
                    </div>
                  </div>
                </div>
              @endif
            @endif
          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo">
            Registro de Personal
          </a></h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse">
          <div class="panel-body">
            <div class="panel-group" id="accordion2">
            @if($datos['data']['detalleComision']['nombre'] == 'nacional')
              @if(isset($datos['data']['registroPersonalNacional']['comisionados']))
                @php $sum = 0
                @endphp
                @foreach ($datos['data']['registroPersonalNacional']['comisionados'] as $key => $item)
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion2" href="#collapseInner{{$key}}">
                        @if(isset($item['nombres']))
                          {{ $item['nombres'] }} {{ $item['paterno'] }} {{  $item['materno'] }}
                        @endif
                      </a></h4>
                    </div>
                    <div id="collapseInner{{$key}}" class="panel-collapse collapse">
                      <div class="panel-body">
                        <div class="row">
                          <h4 class="text-center">
                            @if(isset($item['nombres']))
                            Datos Personales
                            @endif
                          </h4>
                          <div class="col-md-6">
                            @if(isset($item['nombres']) && isset($item['paterno']) && isset($item['materno']))
                              <strong>Nombre: </strong>{{ $item['nombres'] }} {{ $item['paterno'] }} {{  $item['materno'] }}
                            @endif
                          </div>
                          <div class="col-md-6">
                            @if(isset($item['genero']))
                              <strong>Genero: </strong>{{ $item['genero'] }}
                            @endif
                          </div>
                          <br>
                          <br>
                          <div class="col-md-6">
                            @if(isset($item['mail']))
                              <strong>Correo electrónico: </strong>{{ $item['mail'] }}
                            @endif
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <h4 class="text-center">
                            @if(isset($item['tipoIntegrante']))
                            Datos Laborales
                            @endif
                          </h4>
                          <div class="col-md-6">
                            @if(isset($item['numeroEmpleado']))
                              <strong>Número de empleado: </strong>{{ $item['numeroEmpleado'] }} 
                            @endif
                          </div>
                          <div class="col-md-6">
                            @if(isset($item['denominacionCargo']))
                              <strong>Denominación del cargo: </strong>{{ $item['denominacionCargo'] }}
                            @endif
                          </div>
                          <br>
                          <br>
                          <div class="col-md-6">
                            @if(isset($item['tipoIntegrante']))
                              <strong>Tipo de integrante: </strong>{{ $item['tipoIntegrante'] }}
                            @endif
                          </div>
                          <div class="col-md-6">
                            @if(isset($item['nivelPuesto']))
                              <strong>Nivel de puesto (nomenclatura numérica): </strong>{{ $item['nivelPuesto'] }}
                            @endif
                          </div>
                          <br>
                          <br>
                          <div class="col-md-6">
                            @if(isset($item['areaAdscripcion']))
                              <strong>Área de adscricpción: </strong>{{ $item['areaAdscripcion'] }}
                            @endif
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <h4 class="text-center">
                            @if(isset($item['objetivoComisionado']))
                            Actividades
                            @endif
                          </h4>
                          <div class="col-md-6">
                            @if(isset($item['objetivoComisionado']))
                              <strong>Objetivos del comisionado: </strong>{{ $item['objetivoComisionado'] }} 
                            @endif
                          </div>
                          <div class="col-md-6">
                            @if(isset($item['actividadesRealizar']))
                              <strong>Actividades a realizar: </strong>{{ $item['actividadesRealizar'] }}
                            @endif
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <h4 class="text-center">
                            @if(isset($item['pasajes']) && isset($item['viaticos']))
                            Viáticos y Pasajes
                            @endif
                          </h4>
                          <div class="col-md-3">
                            @if(isset($item['viajeViaticos']))
                              <strong>Financiado: </strong>{{ $item['viajeViaticos'] }} 
                            @endif
                          </div>
                          <div class="col-md-3">
                            @if(isset($item['idaVuelta']))
                              <strong>Ida y Vuelta: </strong>{{ $item['idaVuelta'] }}
                            @endif
                          </div>
                          <div class="col-md-6">
                            @if(isset($item['descripcionViatico']))
                              <strong>Descripcion de viático: </strong>{{ $item['descripcionViatico'] }}
                            @endif
                          </div>
                          <br>
                          <br>
                          <br>
                          <br>
                          <div class="col-md-7">
                            <strong>Origen - Destino: </strong>
                            @if(isset($item['saliendoEstadoNacional']))
                              {{ $item['saliendoEstadoNacional'] }}
                            @endif
                            <strong>-</strong>
                            @if(isset($item['saliendoMunicipioNacional']))
                              {{ $item['saliendoMunicipioNacional'] }}
                            @endif
                            <strong> / </strong>
                            @if(isset($item['llegandoEstadoNacional']))
                              {{ $item['llegandoEstadoNacional'] }}
                            @endif
                            <strong>-</strong>
                            @if(isset($item['llegandoMunicipioNacional']))
                              {{ $item['llegandoMunicipioNacional'] }}
                            @endif
                          </div>
                          <div class="col-md-5">
                            <strong>Periodo de la Comisión: </strong>

                            @if(isset($item['dateSalida']))
                              {{ date_format(date_create($item['dateSalida']),'d/m/Y') }}
                            @endif
                            <strong>-</strong>
                            @if(isset($item['dateRegreso']))
                              {{ date_format(date_create($item['dateRegreso']),'d/m/Y') }}
                            @endif
                          </div>
                          <br>
                          <br>
                          <div class="col-md-12">
                            <h4>Pasajes</h4>
                            <div class="table-responsive">
                              <table class="table table-striped">
                                <thead>
                                  <th style="text-align: left !important;">Pasajes (De Acuerdo a la partida que corresponda)</th>
                                  <th style="text-align: left !important;">Monto (Monto por partida)</th>
                                </thead>
                                <tbody>                              
                                  @foreach($item['pasajes'] as $pkey=>$pitem)
                                    @php 
                                    settype($pitem['montoPasajes'], "double")
                                    @endphp
                                    @php 
                                    $sum+= $pitem['montoPasajes']
                                    @endphp
                                    <tr>
                                      <td>{{ $pitem['pasajesPartida'] }}</td>
                                      <td>{{ "$".number_format($pitem['montoPasajes'], 2) }}</td>
                                    </tr>
                                  @endforeach
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <br>
                          <br>
                          <div class="col-md-12">
                            <h4>Viáticos</h4>
                            <div class="table-responsive">
                              <table class="table table-striped">
                                <thead>
                                  <th style="text-align: left !important;">Pasajes (De Acuerdo a la partida que corresponda)</th>
                                  <th style="text-align: left !important;">Monto (Monto por partida)</th>
                                </thead>
                                <tbody>                              
                                  @foreach($item['viaticos'] as $vkey=>$vitem)
                                    @php 
                                    settype($vitem['montoViaticos'], "double")
                                    @endphp
                                    @php 
                                    $sum+= $vitem['montoViaticos']
                                    @endphp
                                    <tr>
                                      <td>{{ $vitem['viaticosPartida'] }}</td>
                                      <td>{{ "$".number_format($vitem['montoViaticos'], 2) }}</td>
                                    </tr>
                                  @endforeach
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
                <br>
                <div class="col-md-12">
                  <strong>Total de comisiones: </strong>
                  {{ "$".number_format($sum, 2) }}
                </div>
                <br>
                @if($datos['data']['status'] == 'rechazadoTitular' || $datos['data']['status'] == 'firmaTitular' || $datos['data']['status'] == 'rechazadoDGA')
                  @if(isset($datos['data']['registroPersonalNacional']['observacionesTitular']))
                    <div class="row">
                      <div class="col-md-12">
                        <h4><strong>Observaciones de los Comisionados (Titular):</strong></h4>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <textarea class="form-control" rows="5" id="comment" disabled="disabled">{{ $datos['data']['registroPersonalNacional']['observacionesTitular'] }}</textarea>
                        </div>
                      </div>
                    </div>
                  @endif
                  @if(isset($datos['data']['registroPersonalNacional']['observacionesDGA']))
                    <div class="row">
                      <div class="col-md-12">
                        <h4><strong>Observaciones de los Comisionados (DGA):</strong></h4>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <textarea class="form-control" rows="5" id="comment" disabled="disabled">{{ $datos['data']['registroPersonalNacional']['observacionesDGA'] }}</textarea>
                        </div>
                      </div>
                    </div>      
                  @endif
                @endif
              @endif
            @else
              @if(isset($datos['data']['registroPersonalInternacional']['comisionados']))
                @php $sum = 0
                @endphp
                @foreach ($datos['data']['registroPersonalInternacional']['comisionados'] as $key => $item)
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion2" href="#collapseInner{{$key}}">
                        @if(isset($item['nombres']))
                          {{ $item['nombres'] }} {{ $item['paterno'] }} {{  $item['materno'] }}
                        @endif
                      </a></h4>
                    </div>
                    <div id="collapseInner{{$key}}" class="panel-collapse collapse">
                      <div class="panel-body">
                        <div class="row">
                          <h4 class="text-center">
                            @if(isset($item['nombres']))
                            Datos Personales
                            @endif
                          </h4>
                          <div class="col-md-6">
                            @if(isset($item['nombres']) && isset($item['paterno']) && isset($item['materno']))
                              <strong>Nombre: </strong>{{ $item['nombres'] }} {{ $item['paterno'] }} {{  $item['materno'] }}
                            @endif
                          </div>
                          <div class="col-md-6">
                            @if(isset($item['genero']))
                              <strong>Genero: </strong>{{ $item['genero'] }}
                            @endif
                          </div>
                          <br>
                          <br>
                          <div class="col-md-6">
                            @if(isset($item['mail']))
                              <strong>Correo electrónico: </strong>{{ $item['mail'] }}
                            @endif
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <h4 class="text-center">
                            @if(isset($item['tipoIntegrante']))
                            Datos Laborales
                            @endif
                          </h4>
                          <div class="col-md-6">
                            @if(isset($item['numeroEmpleado']))
                              <strong>Número de empleado: </strong>{{ $item['numeroEmpleado'] }} 
                            @endif
                          </div>
                          <div class="col-md-6">
                            @if(isset($item['denominacionCargo']))
                              <strong>Denominación del cargo: </strong>{{ $item['denominacionCargo'] }}
                            @endif
                          </div>
                          <br>
                          <br>
                          <div class="col-md-6">
                            @if(isset($item['tipoIntegrante']))
                              <strong>Tipo de integrante: </strong>{{ $item['tipoIntegrante'] }}
                            @endif
                          </div>
                          <div class="col-md-6">
                            @if(isset($item['nivelPuesto']))
                              <strong>Nivel de puesto (nomenclatura numérica): </strong>{{ $item['nivelPuesto'] }}
                            @endif
                          </div>
                          <br>
                          <br>
                          <div class="col-md-6">
                            @if(isset($item['areaAdscripcion']))
                              <strong>Área de adscricpción: </strong>{{ $item['areaAdscripcion'] }}
                            @endif
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <h4 class="text-center">
                            @if(isset($item['objetivoComisionado']))
                            Actividades
                            @endif
                          </h4>
                          <div class="col-md-6">
                            @if(isset($item['objetivoComisionado']))
                              <strong>Objetivos del comisionado: </strong>{{ $item['objetivoComisionado'] }} 
                            @endif
                          </div>
                          <div class="col-md-6">
                            @if(isset($item['actividadesRealizar']))
                              <strong>Actividades a realizar: </strong>{{ $item['actividadesRealizar'] }}
                            @endif
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <h4 class="text-center">
                            @if(isset($item['pasajes']) && isset($item['viaticos']))
                            Viáticos y Pasajes
                            @endif
                          </h4>
                          <div class="col-md-3">
                            @if(isset($item['viajeViaticos']))
                              <strong>Financiado: </strong>{{ $item['viajeViaticos'] }} 
                            @endif
                          </div>
                          <div class="col-md-3">
                            @if(isset($item['idaVuelta']))
                              <strong>Ida y Vuelta: </strong>{{ $item['idaVuelta'] }}
                            @endif
                          </div>
                          <div class="col-md-6">
                            @if(isset($item['descripcionViatico']))
                              <strong>Descripcion de viático: </strong>{{ $item['descripcionViatico'] }}
                            @endif
                          </div>
                          <br>
                          <br>
                          <br>
                          <br>
                          <div class="col-md-7">
                            <strong>Origen - Destino: </strong>
                            @if(isset($item['saliendoContinenteInternacional']))
                              {{ $item['saliendoContinenteInternacional'] }}
                            @endif
                            <strong>-</strong>
                            @if(isset($item['saliendoPaisInternacional']))
                              {{ $item['saliendoPaisInternacional'] }}
                            @endif
                            <strong>-</strong>
                            @if(isset($item['saliendoEntidadInternacional']))
                              {{ $item['saliendoEntidadInternacional'] }}
                            @endif
                            <strong> / </strong>
                            @if(isset($item['llegandoContinenteInternacional']))
                              {{ $item['llegandoContinenteInternacional'] }}
                            @endif
                            <strong>-</strong>
                            @if(isset($item['llegandoPaisInternacional']))
                              {{ $item['llegandoPaisInternacional'] }}
                            @endif
                            <strong>-</strong>
                            @if(isset($item['llegandoEntidadInternacional']))
                              {{ $item['llegandoEntidadInternacional'] }}
                            @endif
                          </div>
                          <div class="col-md-5">
                            <strong>Periodo de la Comisión: </strong>

                            @if(isset($item['dateSalida']))
                              {{ date_format(date_create($item['dateSalida']),'d/m/Y') }}
                            @endif
                            <strong>-</strong>
                            @if(isset($item['dateRegreso']))
                              {{ date_format(date_create($item['dateRegreso']),'d/m/Y') }}
                            @endif
                          </div>
                          <br>
                          <br>
                          <div class="col-md-12">
                            <h4>Pasajes</h4>
                            <div class="table-responsive">
                              <table class="table table-striped">
                                <thead>
                                  <th style="text-align: left !important;">Pasajes (De Acuerdo a la partida que corresponda)</th>
                                  <th style="text-align: left !important;">Monto (Monto por partida)</th>
                                </thead>
                                <tbody>                              
                                  @foreach($item['pasajes'] as $pkey=>$pitem)
                                    @php 
                                    settype($pitem['montoPasajes'], "double")
                                    @endphp
                                    @php 
                                    $sum+= $pitem['montoPasajes']
                                    @endphp
                                    <tr>
                                      <td>{{ $pitem['pasajesPartida'] }}</td>
                                      <td>{{ "$".number_format($pitem['montoPasajes'], 2) }}</td>
                                    </tr>
                                  @endforeach
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <br>
                          <br>
                          <div class="col-md-12">
                            <h4>Viáticos</h4>
                            <div class="table-responsive">
                              <table class="table table-striped">
                                <thead>
                                  <th style="text-align: left !important;">Pasajes (De Acuerdo a la partida que corresponda)</th>
                                  <th style="text-align: left !important;">Monto (Monto por partida)</th>
                                </thead>
                                <tbody>                              
                                  @foreach($item['viaticos'] as $vkey=>$vitem)
                                    @php 
                                    settype($vitem['montoViaticos'], "double")
                                    @endphp
                                    @php 
                                    $sum+= $vitem['montoViaticos']
                                    @endphp
                                    <tr>
                                      <td>{{ $vitem['viaticosPartida'] }}</td>
                                      <td>{{ "$".number_format($vitem['montoViaticos'], 2) }}</td>
                                    </tr>
                                  @endforeach
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
                <br>
                <div class="col-md-12">
                  <strong>Total de comisiones: </strong>
                  {{ "$".number_format($sum, 2) }}
                </div>
                <br>
                @if($datos['data']['status'] == 'rechazadoTitular' || $datos['data']['status'] == 'firmaTitular' || $datos['data']['status'] == 'rechazadoDGA')
                  @if(isset($datos['data']['registroPersonalInternacional']['observacionesTitular']))
                    <div class="row">
                      <div class="col-md-12">
                        <h4><strong>Observaciones de los Comisionados (Titular):</strong></h4>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <textarea class="form-control" rows="5" id="comment" disabled="disabled">{{ $datos['data']['registroPersonalInternacional']['observacionesTitular'] }}</textarea>
                        </div>
                      </div>
                    </div>
                  @endif
                  @if(isset($datos['data']['registroPersonalInternacional']['observacionesDGA']))
                    <div class="row">
                      <div class="col-md-12">
                        <h4><strong>Observaciones de los Comisionados (DGA):</strong></h4>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <textarea class="form-control" rows="5" id="comment" disabled="disabled">{{ $datos['data']['registroPersonalInternacional']['observacionesDGA'] }}</textarea>
                        </div>
                      </div>
                    </div>      
                  @endif
                @endif              
              @endif
            @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    @if(($datos['data']['status'] != 'rechazadoTitular' && $datos['data']['status'] != 'Autorizado') || ($datos['data']['status'] == 'firmaTitular'))
      <div class="row">
        <div class="col-md-4 text-center">
          <a href="#" class="myModalRechazar btn_cdmx">
            <span>Rechazar</span>
          </a>
        </div>
        <div class="col-md-4 text-center">
          <a href="#" class="muestraModalFirma2 btn_cdmx">
            <span>Firmar</span>
          </a>
        </div>
        <div class="col-md-4 text-center"></div>
      </div>
    @endif
    @if($datos['data']['status'] == 'Autorizado')
      <div class="row">
        <div class="col-md-4 col-md-offset-4 text-center">
          <a href="#" class="muestraAutorizado btn_cdmx">
            <span>Autorizado</span>
          </a>          
        </div>
      </div>
    @endif
  </div> 
</div>

<div id="myModalFirma2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div style="width: 100%;text-align: center;" id="modalHeader"></div>
      </div>
      <div class="modal-body">
        <div class="container-fluid bd-example-row estilos">
          <div id="firmaModalBody2" class="row ">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myModalRechazar" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-align: left;"><strong>Observaciones</strong></h4>
      </div>
      <form id="rechazaForm" action="{{ url('/regObs') }}" enctype="multipart/form-data" accept-charset="UTF-8" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="guardaTipo" value="{{ \Session::get('fase.detalleComision.nombre') }}">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <h4 style="color: #333333; text-align: left;" ><label class="checkbox-inline"><input type="checkbox" name="checkboxDetalleComision" id="ceo1" class="ceo">Observaciones del Detalle de la Comisión</label></h4>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <textarea  input="text" disabled="disabled" class="form-control" required="required" rows="5" id="commentDetalleComision" name="commentDetalleComision"></textarea>
              </div>                  
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <h4 style="color: #333333; text-align: left;" ><label class="checkbox-inline"><input type="checkbox" name="checkboxRegistroPersonal" id="ceo2" class="ceo">Observaciones de los Comisionados</label></h4>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <textarea input="text" disabled="disabled" class="form-control" required="required" rows="5" id="commentRegistroPersonal" name="commentRegistroPersonal"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="submit" name="guardaObservacion" disabled="disabled" type="submit" class="btn btn_cdmx">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div id="modalAutorizado" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div style="width: 100%; text-align: center;" id="modalHeader"></div>
      </div>
      <div class="modal-body">
        <div class="tabla">
          <div class="container-fluid bd-example-row estilos">
            <div id="modalAut" class="row ">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="{!! asset('assets/js/bootstrap/jquery.dataTables.min.js') !!}"></script>
<script src="{!! asset('assets/js/bootstrap/dataTables.bootstrap.min.js') !!}"></script>
<script src="{!! asset('assets/js/pdfjs/pdf.js') !!}"></script>
<script src="{!! asset('assets/js/pdfjs/custom.pdf.js') !!}"></script>
@endsection
@section('customjs')
<script type="text/javascript">
  var validacion = 0;
  var firma = 0;
  $(document).ready(function(){
    $(".muestraModalFirma2").click(function(e){
      e.preventDefault();
      if(validacion == 0){
        validacion = 1;
        var id = "{{ $datos['data']['_id'] }}";
        $.ajax({
          url:'{{ url("/pdfFirma")}}',
          data: '_token={{ csrf_token() }}&docId='+id,
          type: 'post',
          dataType: 'json',
          beforeSend: function(){
            $("#modalHeader").html('Firmar Viático');
            $("#firmaModalBody2").html('<img width="100%" src="'+"{{ asset('assets/logotipos/carga.gif')}}"+'">');
            $("#myModalFirma2").modal('show');
          },            
          success: function(response){
            var html = '<form id="firmaForm">'+
              '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
              '<input type="hidden" value="'+id+'" name="docId">'+
              '</form>'+
              '<button class="btn btn-primary" id="zoom_in"><i class="fa fa-search-plus" aria-hidden="true"></i></button>&nbsp;&nbsp;'+
              '<button class="btn btn_cdmx" id="prev"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>'+
              '&nbsp; &nbsp;'+
              '<span>Páginas: <span id="page_num"></span> / <span id="page_count"></span></span>'+
              '&nbsp; &nbsp;'+
              '<button class="btn btn_cdmx" id="next"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>&nbsp;&nbsp;'+
              '<button class="btn btn-primary" id="zoom_out"><i class="fa fa-search-minus" aria-hidden="true"></i></button>&nbsp;&nbsp;'+
              '<button class="btn btn_cdmx" id="firmarTitular">Firmar documento</button>';
            $("#modalHeader").html(html);
            var html = '<div style="height: 70vh; overflow:auto; cursor:default;" class="">'+
              '<canvas id="pdf_scg" style="border: 2px solid black;"></canvas>'+
              '</div>';
            $("#firmaModalBody2").html(html);
            generaPDF(response.pdf,'{{ asset("assets/js/pdfjs/pdf.worker.js") }}');
            $("#firmarTitular").click(function(e){
              e.preventDefault();
              if(firma == 0){
                firma = 1;
                $.ajax({
                  url:    '{{ url("/signDoc") }}',
                  data:   $("#firmaForm").serialize(),
                  type:   'post',
                  dataType:   'json',
                  success:  function(response){
                    if(response.error.code == 0){
                      $('#mensajeModal .modal-body').css('background-color',response.color);
                      $('#mensajeModal .modal-body').text(response.error.msg);
                      $("#mensajeModal").modal('show');
                      setTimeout("$('#mensajeModal').modal('hide')",3000);
                      setTimeout("location.href='"+'{{ url("/svte")}}'+"'",3000);
                    }else{
                      firma = 0;
                      $('#mensajeModal .modal-body').css('background-color',response.color);
                      $('#mensajeModal .modal-body').text(response.error.msg);
                      $("#mensajeModal").modal('show');
                      setTimeout("$('#mensajeModal').modal('hide')",3000);
                    }
                  }
                });
              }else{ alert('no puedes continuar, se esta firmando'); }
            });
            validacion = 0;           
          }        
        });
      }
    });
    $(".muestraAutorizado").click(function(e){
      e.preventDefault();
      var id = "{{ $datos['data']['_id'] }}";
      var tipo = "{{ $datos['data']['status'] }}";      
      $.ajax({
        url:'{{ url("/pdfFirmadoDGA")}}',
        data: '_token={{ csrf_token() }}&docId='+id,
        type: 'post',
        dataType: 'json',
        beforeSend: function(){
          $("#modalAutorizado #modalHeader").html('Viático Firmado');
          $("#modalAutorizado #modalAut").html('<img width="100%" src="'+"{{ asset('assets/logotipos/carga.gif')}}"+'">');
          $("#modalAutorizado").modal('show');
        },
        success: function(response){
          var html = '<form method="post" action="'+"{{ url('/getDetailPDF') }}"+'" id="detalleDescarga">'+
            '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
            '<input type="hidden" name="docId" value="'+id+'">'+
            '<input type="hidden" name="type" value="'+tipo+'">'+
            '</form>'+
            '<button class="btn btn-success" id="download"><i class="fa fa-download" aria-hidden="true"></i></button>&nbsp;&nbsp;'+
            '<button class="btn btn-primary" id="zoom_in"><i class="fa fa-search-plus" aria-hidden="true"></i></button>&nbsp;&nbsp;'+
            '<button class="btn btn_cdmx" id="prev"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>'+
            '&nbsp; &nbsp;'+
            '<span>Páginas: <span id="page_num"></span> / <span id="page_count"></span></span>'+
            '&nbsp; &nbsp;'+
            '<button class="btn btn_cdmx" id="next"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>&nbsp;&nbsp;'+
            '<button class="btn btn-primary" id="zoom_out"><i class="fa fa-search-minus" aria-hidden="true"></i></button>';
          $("#modalAutorizado #modalHeader").html(html);
          var html = '<div style="height: 70vh; overflow:auto; cursor:default;" class="">'+
            '<canvas id="pdf_scg" style="border: 2px solid black;"></canvas>'+
            '</div>';
          $("#modalAutorizado #modalAut").html(html);
          generaPDF(response.pdf,'{{ asset("assets/js/pdfjs/pdf.worker.js") }}');
          validacion = 0;              
        }
      });
      $(document).on('click','#download',function(e){
        e.preventDefault();
        $('#detalleDescarga').submit();
      });
    });

  });
  function toggleIcon(e) { $(e.target) .prev('.panel-heading').find(".more-less").toggleClass('glyphicon-plus glyphicon-minus'); }
  $('.panel-group').on('hidden.bs.collapse', toggleIcon);
  $('.panel-group').on('shown.bs.collapse', toggleIcon);
  $('.myModalRechazar').click(function(e){
    $('#myModalRechazar').modal('show');
  });
  $('.ceo').click(function(){
    var ceo1 = $('input[name="checkboxDetalleComision"]').val($('input[name="checkboxDetalleComision"]').is(':checked')).val();
    var ceo2 = $('input[name="checkboxRegistroPersonal"]').val($('input[name="checkboxRegistroPersonal"]').is(':checked')).val();
    if (ceo1 == "true" && ceo2 == "true") {
      document.getElementById("commentDetalleComision").disabled = false;
      document.getElementById("commentRegistroPersonal").disabled = false;
      document.getElementById("submit").disabled = false;
    }else if(ceo1 == "true" && ceo2 == "false"){
      document.getElementById("commentDetalleComision").disabled = false;
      document.getElementById("commentRegistroPersonal").disabled = true;
      document.getElementById("submit").disabled = false;
    }else if(ceo1 == "false" && ceo2 == "true"){
      document.getElementById("commentDetalleComision").disabled = true;
      document.getElementById("commentRegistroPersonal").disabled = false;
      document.getElementById("submit").disabled = false;
    }else if(ceo1 == "false" && ceo2 == "false"){
      document.getElementById("commentDetalleComision").disabled = true;
      document.getElementById("commentRegistroPersonal").disabled = true;
      document.getElementById("submit").disabled = true;
    }
  });
</script>
@endsection
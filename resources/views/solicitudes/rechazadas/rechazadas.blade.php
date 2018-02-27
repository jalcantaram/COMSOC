@extends('templates.master')
@section('titulo','CDMX | Sistema de CGCS')

@section('head')
    <link rel="stylesheet" href="{!! asset('assets/css/font-awesome/css/font-awesome.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/bootstrap/dataTables.bootstrap.min.css') !!}">
@endsection

@if(Session::get('user.roles.1') == 'Viatinet_Operativo')
@section('nav2')
    @include('templates.nav2',['nav2'=> [ ['nombre'=>'&laquo; Gobierno Digital CDMX','href'=> env('APP_PLATAFORMA_PRINCIPAL')],
                                          ['nombre'=>'Registradas', 'href' => url('/svte')],
                                          ['nombre'=>'Crear nueva', 'href'=> url('/crearNueva')],
                                          ['nombre'=>'Autorizadas', 'href' => url('/autorizadas'), 'id' => 'autorizadas'],
                                          ['nombre'=>'Rechazadas', 'activo' => 'active', 'id' => 'rechazadas']
                                        ]
                              ]
            )
@endsection
@elseif(Session::get('user.roles.1') == 'Viatinet_Titular' || Session::get('user.roles.1') =='Viatinet_supTitular')
@section('nav2')
    @include('templates.nav2',['nav2'=> [ ['nombre'=>'&laquo; Gobierno Digital CDMX','href'=> env('APP_PLATAFORMA_PRINCIPAL')],
                                          ['nombre'=>'Registradas', 'href' => url('/svte')],
                                          ['nombre'=>'Autorizadas', 'href' => url('/autorizadas')],
                                          ['nombre'=>'Rechazadas', 'activo' => 'active']
                                        ]
                              ]
            )
@endsection
@elseif(Session::get('user.roles.1') == 'Viatinet_Dga' || Session::get('user.roles.1') =='Viatinet_supDga')
@section('nav2')
    @include('templates.nav2',['nav2'=> [ ['nombre'=>'&laquo; Gobierno Digital CDMX','href'=> env('APP_PLATAFORMA_PRINCIPAL')],
                                          ['nombre'=>'Registradas', 'href' => url('/svte')],
                                          ['nombre'=>'Autorizadas', 'href' => url('/autorizadas')],
                                          ['nombre'=>'Rechazadas', 'activo' => 'active']
                                        ]
                              ]
            )
@endsection
@elseif(Session::get('user.roles.1') == 'Viatinet_Admin')
@section('nav2')
    @include('templates.nav2',['nav2'=> [ ['nombre'=>'&laquo; Gobierno Digital CDMX','href'=> env('APP_PLATAFORMA_PRINCIPAL')],
                                          ['nombre'=>'Registradas', 'href' => url('/svte')],
                                          ['nombre'=>'Autorizadas', 'href' => url('/autorizadas')],
                                          ['nombre'=>'Rechazadas', 'activo' => 'active']
                                        ]
                              ]
            )
@endsection
@endif

@section('container')  
  <div class="divGeneral">
      <h2>Solicitudes Rechazadas</h2>
      <br>
      <div class="row">
        <form class="form-horizontal" action="{{ url('/exportcsvAut') }}" enctype="multipart/form-data">
          <div class="form-group pull-right">
            <div class="col-md-2">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <button type="submit" class="btn btn_cdmx clearfix"><span class="fa fa-file-excel-o"></span>&nbsp;&nbsp;Exportar a Excel&nbsp;&nbsp;&nbsp;</button>
            </div>
          </div>                    
        </form>           
      </div>
      <br>
      <table id="fichas" class="table table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
              <tr>
                  <th style="display: none;">ID</th>
                  <th>Folio</th>
                  <th>Origen - Destino</th>
                  <th>Duración de la Comisión</th>
                  <th>Monto Total</th>
                  @if(Session::get('user.roles.1') == 'Viatinet_Operativo')
                    <th>Edita</th>
                    <th>Detalle</th>                      
                  @elseif(Session::get('user.roles.1') == 'Viatinet_Titular' || Session::get('user.roles.1') =='Viatinet_supTitular')
                    <th>Valida</th>
                    <th></th>
                  @elseif(Session::get('user.roles.1') == 'Viatinet_Dga' || Session::get('user.roles.1') =='Viatinet_supDga')
                    <th>Autoriza</th>
                    <th></th>
                  @elseif(Session::get('user.roles.1') == 'Viatinet_Admin')
                    <th>Verifica</th>
                    <th></th>
                  @endif
              </tr>
          </thead>
          <tbody>
            @foreach($fichas as $ficha)
              <tr>
                <td style="display: none;">
                  {{ $ficha['_id'] }}
                </td>
                <td align="center">
                  @if(isset($ficha['folio']))
                    {{ $ficha['folio'] }}                      
                  @else
                  @endif
                </td>
                <td align="center">
                  @if($ficha['detalleComision']['nombre'] == 'nacional')
                    @if(isset($ficha['registroPersonalNacional']['comisionados'][0]['saliendoEstadoNacional']))
                      {{ $ficha['registroPersonalNacional']['comisionados'][0]['saliendoEstadoNacional'] }}<span> - </span>{{ $ficha['registroPersonalNacional']['comisionados'][0]['saliendoMunicipioNacional'] }}
                    @endif
                    <span><strong> / </strong></span>
                    @if(isset($ficha['registroPersonalNacional']['comisionados'][0]['llegandoEstadoNacional']))
                      {{ $ficha['registroPersonalNacional']['comisionados'][0]['llegandoEstadoNacional'] }}<span> - </span>{{ $ficha['registroPersonalNacional']['comisionados'][0]['llegandoMunicipioNacional'] }}
                    @endif                    
                  @else
                    @if(isset($ficha['registroPersonalInternacional']['comisionados'][0]['saliendoEntidadInternacional']))
                      {{ $ficha['registroPersonalInternacional']['comisionados'][0]['saliendoPaisInternacional'] }}<span> - </span>{{ $ficha['registroPersonalInternacional']['comisionados'][0]['saliendoEntidadInternacional'] }}
                    @endif
                    <span><strong> / </strong></span>
                    @if(isset($ficha['registroPersonalInternacional']['comisionados'][0]['llegandoEntidadInternacional']))
                      {{ $ficha['registroPersonalInternacional']['comisionados'][0]['llegandoPaisInternacional'] }}<span> - </span>{{ $ficha['registroPersonalInternacional']['comisionados'][0]['llegandoEntidadInternacional'] }}
                    @endif
                  @endif
                </td>
                <td align="center">
                  @if($ficha['detalleComision']['nombre'] == 'nacional')
                    @if(isset($ficha['registroPersonalNacional']['comisionados'][0]['dateSalida']))
                      {{ date_format(date_create($ficha['registroPersonalNacional']['comisionados'][0]['dateSalida']),'d/m/Y') }}
                    @endif
                  @else
                    @if(isset($ficha['registroPersonalInternacional']['comisionados'][0]['dateSalida']))
                      {{ date_format(date_create($ficha['registroPersonalInternacional']['comisionados'][0]['dateSalida']),'d/m/Y') }}
                    @endif
                  @endif
                  <strong>-</strong>
                  @if($ficha['detalleComision']['nombre'] == 'nacional')
                    @if(isset($ficha['registroPersonalNacional']['comisionados'][0]['dateRegreso']))
                      {{ date_format(date_create($ficha['registroPersonalNacional']['comisionados'][0]['dateRegreso']),'d/m/Y') }}
                    @endif
                  @else
                    @if(isset($ficha['registroPersonalInternacional']['comisionados'][0]['dateRegreso']))
                      {{ date_format(date_create($ficha['registroPersonalInternacional']['comisionados'][0]['dateRegreso']),'d/m/Y') }}
                    @endif
                  @endif
                </td>
                <td align="center">
                  @if($ficha['detalleComision']['nombre'] == 'nacional')
                    @if(isset($ficha['registroPersonalNacional']['comisionados']))
                      @php $sum = 0
                      @endphp
                      @foreach ($ficha['registroPersonalNacional']['comisionados'] as $key=>$item)
                        @foreach($item['pasajes'] as $pkey=>$pitem)
                          @php 
                          settype($pitem['montoPasajes'], "double")
                          @endphp
                          @php 
                          $sum+= $pitem['montoPasajes']
                          @endphp
                        @endforeach
                        @foreach($item['viaticos'] as $vkey=>$vitem)
                          @php 
                          settype($vitem['montoViaticos'], "double")
                          @endphp
                          @php 
                          $sum+= $vitem['montoViaticos']
                          @endphp
                        @endforeach
                      @endforeach
                      {{ "$".number_format($sum, 2) }}
                    @endif
                  @else
                    @if(isset($ficha['registroPersonalInternacional']['comisionados']))
                      @php $sum = 0
                      @endphp
                      @foreach ($ficha['registroPersonalInternacional']['comisionados'] as $key=>$item)
                        @foreach($item['pasajes'] as $pkey=>$pitem)
                          @php 
                          settype($pitem['montoPasajes'], "double")
                          @endphp
                          @php 
                          $sum+= $pitem['montoPasajes']
                          @endphp
                        @endforeach
                        @foreach($item['viaticos'] as $vkey=>$vitem)
                          @php 
                          settype($vitem['montoViaticos'], "double")
                          @endphp
                          @php 
                          $sum+= $vitem['montoViaticos']
                          @endphp
                        @endforeach
                      @endforeach
                      {{ "$".number_format($sum, 2) }}
                    @endif
                  @endif
                </td>                  
                @if(Session::get('user.roles.1') == 'Viatinet_Operativo')
                  <td align="center">
                      @if($ficha['status'] == 'rechazadoTitular' || $ficha['status'] == 'rechazadoDGA')
                        <a href="{{ url('/efsvte?f='.$ficha['_id'].'&n='.$ficha['detalleComision']['nombre']) }}" class="btn btn-default" role="button">
                          <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </a>
                      @endif
                  </td>
                  <td align="center">
                    <a href="{{ url('/info?sess='.Session::get('sessionId').'&f='.$ficha['_id']) }}" class="btn btn-default" role="button">
                      <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
                    </a>
                  </td>
                @elseif(Session::get('user.roles.1') == 'Viatinet_Titular' || Session::get('user.roles.1') =='Viatinet_supTitular')
                  <td align="center">
                    @if($ficha['status'] == 'firmaTitular')
                      <a href="{{ url('/validaTitular?sess='.Session::get('sessionId').'&f='.$ficha['_id']) }}" class="btn btn-default" role="button">
                        <span class="glyphicon glyphicon-saved" aria-hidden="true"></span>
                      </a>
                    @endif
                  </td>
                  <td align="center">
                    @if($ficha['status'] == 'firmaDGA')
                      <a href="#" class="muestraModalFirmado_{{ $ficha['_id'] }}" id="muestraModalFirmado">
                        <input type="hidden" value="{{ $ficha['_id'] }}">
                        <span>Firmado</span>
                      </a>
                    @endif
                  </td>
                @elseif(Session::get('user.roles.1') == 'Viatinet_Dga' || Session::get('user.roles.1') =='Viatinet_supDga')
                  <td align="center">
                    <a href="{{ url('/efsvte?f='.$ficha['_id'].'&n='.$ficha['detalleComision']['nombre']) }}" class="btn btn-default" role="button">
                      <span class="glyphicon glyphicon-saved" aria-hidden="true"></span>
                    </a>
                  </td>
                @elseif(Session::get('user.roles.1') == 'Viatinet_Admin')
                  <td align="center">
                    <a href="{{ url('/efsvte?f='.$ficha['_id'].'&n='.$ficha['detalleComision']['nombre']) }}" class="btn btn-default" role="button">
                      <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
                    </a>
                  </td> 
                @endif
              </tr>
            @endforeach
          </tbody>
      </table>
  </div>
@endsection

@section('js')
  <script src="{!! asset('assets/js/bootstrap/jquery.dataTables.min.js') !!}"></script>
  <script src="{!! asset('assets/js/bootstrap/dataTables.bootstrap.min.js') !!}"></script>
@endsection

@section('customjs')
  <script type="text/javascript">
    $('#fichas').DataTable({
      "language": {
        "lengthMenu": "Mostrar: _MENU_ por página",
        "zeroRecords": "No existen registros",
        "info": "Página _PAGE_ de _PAGES_",
        "infoEmpty": "No existen registros",
        "infoFiltered": "(Filtrados de _MAX_ totales)",
        "paginate": {
            "first":      "Primero",
            "last":       "Último",
            "next":       "Siguiente",
            "previous":   "Anterior"
        },
        "search": "Buscar"
      }
    });
    var countAut = "{{ $fichasAut }}", countRech = "{{ count($fichas) }}";
    if (countAut != 0) {
      $('<span class="badge badge-success">'+countAut+'</span>').appendTo('a#autorizadas');
    }
    if(countRech != 0){
      $('<span class="badge badge-warning">'+countRech+'</span>').appendTo('a#rechazadas');
    }
  </script>
@endsection
@extends('templates.master')
@section('titulo','CDMX | Sistema de CGCS')
@section('head')
<link rel="stylesheet" href="{!! asset('assets/css/font-awesome/css/font-awesome.min.css') !!}">
<link rel="stylesheet" href="{!! asset('assets/css/bootstrap/dataTables.bootstrap.min.css') !!}">
@endsection
  @if(Session::get('user.roles.1') == 'Comsoc_operativo')
    @section('nav2')
      @include('templates.nav2',['nav2'=> [ 
          ['nombre'=>'&laquo; Gobierno Digital CDMX','href'=> env('APP_PLATAFORMA_PRINCIPAL')],
          ['nombre'=>'Registros','activo'=>'active'],
          ['nombre'=>'Registrar expediente', 'href'=> url('/crearNueva')],
          ['nombre'=>'Autorizadas', 'href'=> url('/autorizadas'), 'id' => 'autorizadas'],
          ['nombre'=>'Rechazadas', 'href'=> url('/rechazadas'), 'id' => 'rechazadas'],
          ['nombre'=>'<i class="glyphicon glyphicon-book" aria-hidden="true"></i> Manual de Usuario', 'link'=>'', 'modal'=>'#myModalope']
        ]
      ])
    @endsection
  @elseif(Session::get('user.roles.1') == 'Comsoc_validador')
    @section('nav2')
      @include('templates.nav2',['nav2'=> [ 
          ['nombre'=>'&laquo; Gobierno Digital CDMX','href'=> env('APP_PLATAFORMA_PRINCIPAL')],
          ['nombre'=>'Registros','activo'=>'active'],
          ['nombre'=>'Autorizadas', 'href'=> url('/autorizadoTitular'), 'id' => 'autorizadas'],
          ['nombre'=>'Rechazadas', 'href'=> url('/rechazadoTitular'), 'id' => 'rechazadas'],
          ['nombre'=>'<i class="glyphicon glyphicon-book" aria-hidden="true"></i> Manual de Usuario', 'link'=>'', 'modal'=>'#myModaltit']
        ]
      ])
    @endsection
  @elseif(Session::get('user.roles.1') == 'Comsoc_supervisor')
    @section('nav2')
      @include('templates.nav2',['nav2'=> [ 
          ['nombre'=>'&laquo; Gobierno Digital CDMX','href'=> env('APP_PLATAFORMA_PRINCIPAL')],
          ['nombre'=>'Registros','activo'=>'active'],
          ['nombre'=>'Autorizadas', 'href'=> url('/autorizadoDga'), 'id' => 'autorizadas'],
          ['nombre'=>'Rechazadas', 'href'=> url('/rechazadoDga'), 'id' => 'rechazadas'],
          ['nombre'=>'<i class="glyphicon glyphicon-book" aria-hidden="true"></i> Manual de Usuario', 'link'=>'', 'modal'=>'#myModaldga']
        ]
      ])
    @endsection
    @elseif(Session::get('user.roles.1') == 'Comsoc_titular')
    @section('nav2')
      @include('templates.nav2',['nav2'=> [ 
          ['nombre'=>'&laquo; Gobierno Digital CDMX','href'=> env('APP_PLATAFORMA_PRINCIPAL')],
          ['nombre'=>'Registros','activo'=>'active'],
          ['nombre'=>'Autorizadas', 'href'=> url('/autorizadoDga'), 'id' => 'autorizadas'],
          ['nombre'=>'Rechazadas', 'href'=> url('/rechazadoDga'), 'id' => 'rechazadas'],
          ['nombre'=>'<i class="glyphicon glyphicon-book" aria-hidden="true"></i> Manual de Usuario', 'link'=>'', 'modal'=>'#myModaldga']
        ]
      ])
    @endsection
  @elseif(Session::get('user.roles.1') == 'Comsoc_admin')
    @section('nav2')
      @include('templates.nav2',['nav2'=> [ 
          ['nombre'=>'&laquo; Gobierno Digital CDMX','href'=> env('APP_PLATAFORMA_PRINCIPAL')],
          ['nombre'=>'Registros','activo'=>'active'],
          ['nombre'=>'Autorizadas', 'href'=> url('/autorizadas')],
          ['nombre'=>'Rechazadas', 'href'=> url('/rechazadas')]
        ]
      ])
    @endsection
  @endif
  @section('container')
    <div class="divGeneral">
        <h2>Expedientes Registrados</h2>
  
        <br>
        <div class="row">
          <form class="form-horizontal" action="{{ url('/exportcsv') }}" enctype="multipart/form-data">
            <div class="form-group pull-right">
              <div class="col-md-2">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn_cdmx clearfix"><span class="fa fa-file-excel-o"></span>&nbsp;&nbsp;Exportar a Excel&nbsp;&nbsp;&nbsp;</button>
              </div>
            </div>                    
          </form>           
        </div>
        <br>
        <div class="table-responsive">
          <table id="fichas" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Folio</th>
                <th>Tipo</th>
                <th>Fecha registro</th>
                <th>Status</th>
                <th>Detalle</th>
                @if(Session::get('user.roles.1') == 'Comsoc_Operativo')
                  <th>Edita</th>
                  <th>Detalle</th>                      
                @elseif(Session::get('user.roles.1') == 'Comsoc_Titular' || Session::get('user.roles.1') =='Comsoc_supTitular')
                  <th>Valida</th>
                  <th>{{ isset($ficha['status']) ? $ficha['status'] : 'Constancia' }}</th>
                @elseif(Session::get('user.roles.1') == 'Comsoc_Dga' || Session::get('user.roles.1') =='Comsoc_supDga')
                  <th>Autoriza</th>
                @elseif(Session::get('user.roles.1') == 'Comsoc_Admin')
                  <th>Verifica</th>
                  <th></th>
                @endif
              </tr>
            </thead>
            <tbody>
              @foreach($fichas as $key => $dato)
                <tr>
                  <td>{{ $dato['folio'] }}</td>
                  <td>
                    @php $val = ''; @endphp
                    @foreach($dato['type'] as $name)
                      @php 
                        $val != '' && $val .= ' / ';
                        $val .= $name
                      @endphp
                    @endforeach
                    {{ $val }}
                  </td>
                  <td>{{ date('d/m/Y H:i:s', strtotime($dato['created'])) }}</td>
                  <td>{{ $dato['status'] }}</td>
                  <td class="text-center">
                    <a href="{{ url('/efsvte?f='.$dato['_id']) }}" class="btn btn-default" role="button">
                      <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>        
        </div>
    </div>
    <div id="myModalFirma" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div style="width: 100%; text-align: center;" id="modalHeader"></div>
          </div>
          <div class="modal-body">
            <div class="tabla">
            <div class="container-fluid bd-example-row estilos">
              <div id="firmaModalBody" class="row ">
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
      $(document).ready(function() {
        var validacion = 0;
        var firma = 0;
        var table = $('#fichas').DataTable({
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
        $('#fichas tbody').on('click', 'a#muestraModalFirmado', function () {
            var data = table.row($(this).parents('tr')).data();
            var id = data[0];
            if(validacion == 0){
              $.ajax({
                url:'{{ url("/pdfFirmadoTitular")}}',
                data: '_token={{ csrf_token() }}&docId='+id,
                type: 'post',
                dataType: 'json',
                beforeSend: function(){
                  $("#modalHeader").html('Viático Firmado');
                  $("#firmaModalBody").html('<img width="100%" src="'+"{{ asset('assets/logotipos/carga.gif')}}"+'">');
                  $("#myModalFirma").modal('show');
                },
                success: function(response){
                  var html = '<form method="post" action="'+"{{ url('/getDetailPDF') }}"+'" id="detalleDescarga">'+
                  '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
                  '<input type="hidden" name="docId" value="'+id+'">'+
                  '</form>'+
                  '<button class="btn btn-success" id="download"><i class="fa fa-download" aria-hidden="true"></i></button>&nbsp;&nbsp;' + 
                  '<button class="btn btn-primary" id="zoom_in"><i class="fa fa-search-plus" aria-hidden="true"></i></button>&nbsp;&nbsp;'+
                  '<button class="btn btn_cdmx" id="prev"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>'+
                  '&nbsp; &nbsp;'+
                  '<span>Páginas: <span id="page_num"></span> / <span id="page_count"></span></span>'+
                  '&nbsp; &nbsp;'+
                  '<button class="btn btn_cdmx" id="next"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>&nbsp;&nbsp;'+
                  '<button class="btn btn-primary" id="zoom_out"><i class="fa fa-search-minus" aria-hidden="true"></i></button>';
                  $("#modalHeader").html(html);
                  var html =  '<div style="height: 70vh; overflow:auto; cursor:default;" class="">'+
                          '<canvas id="pdf_scg" style="border: 2px solid black;"></canvas>'+
                          '</div>';
                  $("#firmaModalBody").html(html);
                  generaPDF(response.pdf,'{{ asset("assets/js/pdfjs/pdf.worker.js") }}');
                  validacion = 0;              
                }
              });
            }
            $(document).on('click','#download',function(e){
              e.preventDefault();
              $('#detalleDescarga').submit();
            });
        });
        {{--  var countRech = "{{ $fichasRech }}", countAut = "{{ $fichasAut }}";
        if (countAut != 0) {
          $('<span class="badge badge-success">'+countAut+'</span>').appendTo('a#autorizadas');
        }
        if(countRech != 0){
          $('<span class="badge badge-warning">'+countRech+'</span>').appendTo('a#rechazadas');
        }  --}}
        $('#showPass').on('click', function(){
          if ($('#password').get(0).type == 'password') {
            $('#password').attr('type', 'text');
          }else{
            $('#password').attr('type', 'password');
          }
        });
      });
    </script>
  @endsection
@extends('templates.master')
@section('titulo','CDMX | Sistema de CGCS')
@section('head')
<link rel="stylesheet" href="{!! asset('assets/css/font-awesome/css/font-awesome.min.css') !!}">
<link rel="stylesheet" href="{!! asset('assets/css/bootstrap/dataTables.bootstrap.min.css') !!}">
@endsection
@section('nav2')
  @include('templates.nav2',['nav2'=> [ 
      ['nombre'=>'&laquo; Gobierno Digital CDMX','href'=> env('APP_PLATAFORMA_PRINCIPAL')],
      ['nombre'=>'Registradas', 'href' => url('/svte')],
      ['nombre'=>'Crear nueva', 'href'=> url('/crearNueva')],
      ['nombre'=>'Autorizadas', 'activo' => 'active', 'id' => 'autorizadas'],
      ['nombre'=>'Rechazadas',  'href' => url('/rechazadas'), 'id' => 'rechazadas']
    ]
  ])
@endsection
@section('container')  
  <div class="divGeneral">
    <h2>Solicitudes Autorizadas</h2>
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
          <th>Constancia</th>                      
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
            <td align="center">
              <a href="#" class="muestraModalFirmado_{{ $ficha['_id'] }} btn btn_cdmx" id="muestraModalFirmado">
                <input type="hidden" value="{{ $ficha['_id'] }}">
                <i class="fa fa-file-text-o" aria-hidden="true"></i>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
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
  var validacion = 0;
  var firma = 0;
  var table = $('#fichas').DataTable({
    "columnDefs": [
      {
          "targets": [ 0 ],
          "visible": false,
          "searchable": false
      }
    ],
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
          url:'{{ url("/pdfFirmadoDGA")}}',
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
  var countRech = "{{ $fichasRech }}", countAut = "{{ count($fichas) }}";
  if (countAut != 0) {
    $('<span class="badge badge-success">'+countAut+'</span>').appendTo('a#autorizadas');
  }
  if(countRech != 0){
    $('<span class="badge badge-warning">'+countRech+'</span>').appendTo('a#rechazadas');
  }
</script>
@endsection
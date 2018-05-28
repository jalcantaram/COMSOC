@extends('templates.master')
@section('titulo','CDMX | Sistema de CGCS')
@section('head')
<link rel="stylesheet" href="{!! asset('assets/css/font-awesome/css/font-awesome.min.css') !!}">
<link rel="stylesheet" href="{!! asset('assets/css/jquery.datetimepicker.css') !!}">
<link rel="stylesheet" href="{!! asset('assets/css/tipsy.css') !!}">
@endsection
@section('nav2')
  @include('templates.nav2',[
    'nav2'=>[ 
      ['nombre'=>'&laquo; Regresar', 'href'=> url(Session::get('urlBack'))],

    ]
  ])
@endsection
@section('container')
    <input type="hidden" id="cambio" value="0">
    <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header" style="border-bottom: 1px solid trasparent">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="itemModalLabel" style="text-align: left;"></h4>
          </div>
          <div id="itemModalBody" class="modal-body" style="margin: 2% 6% 6% 6%; color:#333333">
          </div>
        </div>
      </div>
    </div>  
    <div class="divIzquierdo">
      <div class="sidebar">
        <div class="titulo" style="font-size:18px">Registro de expediente</div>
        <div class="elementos">
          <ul>
            @foreach($sidebar as $key => $item)
              @php
                $tipoFase = []; 
                $fases = Session::get('fase.type');
              @endphp
              @foreach($item['type'] as $type)
                @foreach(array_keys($fases) as $k => $dataFase)
                  @if($type == $k)
                    @php $tipoFase[] = in_array($type, array_keys($fases)); @endphp
                  @endif
                @endforeach
              @endforeach
                {{--  @if(in_array(true, $tipoFase))  --}}
                {{--  @php dd([$key, Session::get('fase.'.$key.'.vacio'), !Session::has('fase.'.$key.'.vacio')]); @endphp  --}}
                @if(in_array(true,$tipoFase))
                  <li class="{{ (isset($item['active']))? 'active':'' }}">
                    <a class="enviaFase" href="{{ url('/svte/'.$item['id']) }}">
                      <div>

                        {{--  @if($key != 'requisicion')
                          @if(Session::get('fase.'.$key.'.vacio') || !Session::has('fase.'.$key.'.vacio'))
                              <i id="{{ $item['id'] }}" class="fa fa-close cross"></i>
                          @else
                              <i id="{{ $item['id'] }}" class="fa fa-check check"></i>
                          @endif
                        @else  --}}
                          @if(Session::get('fase.'.$key.'.vacio') || !Session::has('fase.'.$key.'.vacio'))
                              <i id="{{ $item['id'] }}" class="fa fa-close cross"></i>
                          @else
                              <i id="{{ $item['id'] }}" class="fa fa-check check"></i>
                          @endif
                        {{--  @endif  --}}
                        <label class="sideBarItem">{{ $item['nombre'] }}</label>
                      </div>
                    </a>
                  </li>
                @endif
            @endforeach
          </ul>
        </div>
      </div>
    </div>
    <div class="divDerecho">
    @php ($view = 'fsvte.'.Session::get('faseActual'))
    @if($sidebar[Session::get('faseActual')]['array'] && Session::get('faseStatus.'.Session::get('faseActual'))=='table')
      @include('fsvte.detalleArray')
    @else
      @include('fsvte.detalle')
    @endif
    </div>
@endsection
@section('js')
  <script src="{!! asset('assets/js/jquery.lockfixed.js') !!}"></script>
  <script src="{!! asset('assets/js/jquery.number.js') !!}"></script>
  <script src="{!! asset('assets/js/jquery.datetimepicker.js') !!}"></script>
  <script src="{!! asset('assets/js/jquery.tipsy.js') !!}"></script>

  <script src="{!! asset('js/upload/vendor/jquery.ui.widget.js') !!}"></script>
    <script src="{!! asset('js/upload/jquery.iframe-transport.js') !!}"></script>
  <script src="{!! asset('js/upload/jquery.fileupload.js') !!}"></script>
  <script src="{!! asset('js/upload/jquery.fileupload-process.js') !!}"></script>
  <script src="{!! asset('js/upload/jquery.fileupload-validate.js') !!}"></script>


@endsection
@section('customjs')
  <script type="text/javascript">
    $(document).ready(function(){
      $.lockfixed(".sidebar",{offset: {top: 100, bottom: 65}}); 
      var auxiliar = '';
      $(".modal-body").on('click','.notifySi',function(){ setTimeout("$('#mensajeModal').modal('hide')",10); $(window).unbind('beforeunload'); location.href = auxiliar;  });
      $(".modal-body").on('click','.notifyNo',function(){ setTimeout("$('#mensajeModal').modal('hide')",10); });
      $(".modal-body").on('click','.notifyDel',function(){ auxiliar.parent().parent().remove(); auxiliar=''; setTimeout("$('#mensajeModal').modal('hide')",10); });
      $('#form').on('click','.btn-delItem',function(){
        $('.modal-body').css('background-color','#C6383D');
        $('.modal-body').css('font-weight','normal');
        $('.modal-body').html('<br>¿Desea eliminar el elemento?<br><br>'+
          '<button class="botonesNotify notifyDel">Si</button>'+
          '<button class="botonesNotify notifyNo">No</button><br><br>');
        $("#mensajeModal").modal('show');
        auxiliar = $(this);
      });
      $(".enviaFase").click(function(event){
        if($("#cambio").val() != '0'){
          $('.modal-body').css('background-color','#C6383D');
          $('.modal-body').css('font-weight','normal');
          $('.modal-body').html('<br>No guardó los cambios,<br>se perderán si continua. <br>¿Desea continuar?<br><br>'+
            '<button class="botonesNotify notifySi">Si</button>'+
            '<button class="botonesNotify notifyNo">No</button><br><br>');
          $("#mensajeModal").modal('show');
          event.preventDefault();
          auxiliar = $(this).prop('href');
        }else{
          $(window).unbind('beforeunload');
        }
      });

      $(window).on('beforeunload', function(event){
        return confirm("Do you really want to close?");    
      });

      $("#form").on('keyup','input',function(){ $("#cambio").val('1'); });

      $('#envioFin').click(function(event){
          event.preventDefault();
          $("input").removeClass('bordeRojo');
          $("select").removeClass('bordeRojo');
          $("textarea").removeClass('bordeRojo');
          $('.tipsy').remove();
          $.ajax({
              url: '{{ url("/ffsvte") }}',
              data: $("#formFin").serialize(),
              type: 'post',
              dataType: 'json',
              success: function(response){
                if(response.error == 0){
                    $('#'+response.etapa).removeClass('fa-close cross').addClass('fa-check check');
                    $("#cambio").val('0');
                }else{
                    if(response.error == 99){
                        $.each(response.validacion,function(k,i){ 
                            if(jQuery.type(i) != 'object' && jQuery.type(i) != 'array'){
                                if(i!=0){ 
                                    $("input[name='"+k+"']").addClass('bordeRojo')
                                                            .attr('original-title',i)
                                                            .tipsy({ trigger: 'manual', gravity: 'w'})
                                                            .tipsy('show');
                                    $("select[name='"+k+"']").addClass('bordeRojo')
                                                             .attr('original-title',i)
                                                             .tipsy({ trigger: 'manual', gravity: 'w'})
                                                             .tipsy('show');
                                    $("textarea[name='"+k+"']").addClass('bordeRojo')
                                                               .attr('original-title',i)
                                                               .tipsy({ trigger: 'manual', gravity: 'w'})
                                                               .tipsy('show');
                                }
                            }else{
                                $.each(i,function(k2,i2){
                                    if(jQuery.type(i2) != 'object'){
                                        if(i2!=0){ 
                                            $("input[name='"+k+"["+k2+"]']").addClass('bordeRojo')
                                                            .attr('original-title',i2)
                                                            .tipsy({ trigger: 'manual', gravity: 'w'})
                                                            .tipsy('show');
                                            $("select[name='"+k+"["+k2+"]']").addClass('bordeRojo')
                                                                     .attr('original-title',i2)
                                                                     .tipsy({ trigger: 'manual', gravity: 'w'})
                                                                     .tipsy('show');
                                            $("textarea[name='"+k+"["+k2+"]']").addClass('bordeRojo')
                                                                       .attr('original-title',i2)
                                                                       .tipsy({ trigger: 'manual', gravity: 'w'})
                                                                       .tipsy('show');
                                        }
                                    }else{
                                        $.each(i2,function(k3,i3){
                                            if(i3!=0){ 
                                                $("input[name='"+k+"["+k2+"]["+k3+"]']").addClass('bordeRojo')
                                                                .attr('original-title',i3)
                                                                .tipsy({ trigger: 'manual', gravity: 's'})
                                                                .tipsy('show');
                                                $("select[name='"+k+"["+k2+"]["+k3+"]']").addClass('bordeRojo')
                                                                         .attr('original-title',i3)
                                                                         .tipsy({ trigger: 'manual', gravity: 's'})
                                                                         .tipsy('show');
                                                $("textarea[name='"+k+"["+k2+"]["+k3+"]']").addClass('bordeRojo')
                                                                           .attr('original-title',i3)
                                                                           .tipsy({ trigger: 'manual', gravity: 's'})
                                                                           .tipsy('show');
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }
                }
                $('.modal-body').css('background-color',response.color);
                $('.modal-body').html(response.msg+'<br> <br>'+'NOTA: Este tramite se ha enviado a la bandeja del Titular para su validación');
                $("#mensajeModal").modal('show');
                $('#collapse1').collapse('show');
                setTimeout(function(){
                    $('#mensajeModal').modal('hide');
                    setTimeout(function(){
                        if(response.error == 0){
                            location.href = "{{ url('/svte/') }}";
                        }
                    },500);
                },5500);
              }
          });
      });

      $('#envio').click(function(event){
        event.preventDefault();
        $("input").removeClass('bordeRojo');
        $("select").removeClass('bordeRojo');
        $("textarea").removeClass('bordeRojo');
        $('.tipsy').remove();
        $('#collapse1').collapse('show');
        $('#collapse2').collapse('show');
        $('#collapse3').collapse('show');
        $('#collapse4').collapse('show');
        $.ajax({
          url: '{{ url("/gfsvte") }}',
          data: $("#form").serialize(),
          type: 'post',
          dataType: 'json',
          success: function(response){
            if(response.error == 0){
              $('#'+response.etapa).removeClass('fa-close cross').addClass('fa-check check');
              $("#cambio").val('0');
            }else{
              if(response.error == 99){
                $.each(response.validacion,function(k,i){ 
                  if(jQuery.type(i) != 'object' && jQuery.type(i) != 'array'){
                    if(i!=0){
                      $("input[name='"+k+"']").addClass('bordeRojo')
                        .attr('original-title',i)
                        .tipsy({ trigger: 'manual', gravity: 'w'})
                        .tipsy('show');
                      $("select[name='"+k+"']").addClass('bordeRojo')
                        .attr('original-title',i)
                        .tipsy({ trigger: 'manual', gravity: 'w'})
                        .tipsy('show');
                      $("textarea[name='"+k+"']").addClass('bordeRojo')
                        .attr('original-title',i)
                        .tipsy({ trigger: 'manual', gravity: 'w'})
                        .tipsy('show');
                      $("#buttonFileUpload_"+k+"").addClass('bordeRojo')
                        .attr('original-title',i)
                        .tipsy({ trigger: 'manual', gravity: 'w'})
                        .tipsy('show');
                    }else{
                      $("#buttonFileUpload_"+k+"").removeClass('bordeRojo');
                    }
                  }else{
                    $.each(i,function(k2,i2){
                      if(jQuery.type(i2) != 'object'){
                          if(i2!=0){ 
                            $("input[name='"+k+"["+k2+"]']").addClass('bordeRojo')
                                            .attr('original-title',i2)
                                            .tipsy({ trigger: 'manual', gravity: 'w'})
                                            .tipsy('show');
                            $("select[name='"+k+"["+k2+"]']").addClass('bordeRojo')
                                                      .attr('original-title',i2)
                                                      .tipsy({ trigger: 'manual', gravity: 'w'})
                                                      .tipsy('show');
                            $("textarea[name='"+k+"["+k2+"]']").addClass('bordeRojo')
                                                        .attr('original-title',i2)
                                                        .tipsy({ trigger: 'manual', gravity: 'w'})
                                                        .tipsy('show');
                            var l = 0;
                            if (k2 == 'montoPasajes') {
                              var t = 'input[name="'+k+'[pasajes]['+(l++)+']['+k2+']"]';
                              console.log(t);
                              $(t).addClass('bordeRojo')
                                .attr('original-title',i2)
                                .tipsy({ trigger: 'manual', gravity: 'w'})
                                .tipsy('show');                                              
                            }
                          }
                      }else{
                          $.each(i2,function(k3,i3){
                              if(i3!=0){ 
                                $("input[name='"+k+"["+k2+"]["+k3+"]']").addClass('bordeRojo')
                                                .attr('original-title',i3)
                                                .tipsy({ trigger: 'manual', gravity: 's'})
                                                .tipsy('show');
                                $("select[name='"+k+"["+k2+"]["+k3+"]']").addClass('bordeRojo')
                                                          .attr('original-title',i3)
                                                          .tipsy({ trigger: 'manual', gravity: 's'})
                                                          .tipsy('show');
                                $("textarea[name='"+k+"["+k2+"]["+k3+"]']").addClass('bordeRojo')
                                                            .attr('original-title',i3)
                                                            .tipsy({ trigger: 'manual', gravity: 's'})
                                                            .tipsy('show');
                              }
                          });
                      }
                    });
                  }
                });
              }
            }
            $('.modal-body').css('background-color',response.color);
            $('.modal-body').text(response.msg);
            $("#mensajeModal").modal('show');
            setTimeout(function(){
              $('#mensajeModal').modal('hide');
              setTimeout(function(){
                if(response.error == 0){
                  $(window).unbind('beforeunload');
                  location.href = "{{ url('/svte/'.Session::get('faseActual')) }}";
                }
              },500);
            },3000);
          }
        });
      });

      function actualizaTotal(){ var sum = 0; $('.calendario-total').each(function(){sum += parseInt($(this).val()); }); $("#calendario-total").number( sum , 2, '.', ',' ); }

      jQuery.datetimepicker.setLocale('es');

      $('.date').datetimepicker({ timepicker: false, scrollInput:false, format: 'd-m-Y' });

      $('.datetime').datetimepicker({ format: 'd-m-Y H:i', scrollInput:false, });

      $('.time').datetimepicker({ datepicker: false, scrollInput:false, format: 'H:i' });

      $('.integer').number(true,0);

      $('.unsigned').number(true,0,'','');

      $('.pct').number(true,0,'','');

      $('.double').number(true,2);

      $('.float').number(true,2);

      $('.real').number(true,2);

      $('#form').on('keyup','.calendario-total',function(){ actualizaTotal(); });

      $('#form').on('blur','.calendario-total',function(){ actualizaTotal(); });

      $(document).on('click','.agregaItemModal',function(event){
        event.preventDefault();
        $("#itemModalBody").css('background-color','#FFFFFF');
        $("#itemModalLabel").text($(this).children('.itemModalLabel').val());
        var params={};
        params['id']=$(this).children('.itemModalId').val();
        params['position']=0;
        params['_token']=$('#token').val();
        params['itemToken']=$(this).children('.itemModalToken').val();
        $.ajax({
          url: '{{ url("/newItemModal") }}',
          data: params,
          type: 'post',
          dataType: 'json',
          success: function(response){
            $("#itemModalBody").html(response.item);
            $("#itemModal").modal('show');
          }
        });
      });

      $("#itemModal").on('click','.cargaItemModal',function(event){
        event.preventDefault();
        $.ajax({
            url: '{{ url("/loadItemModal") }}',
            data: $('#formItemModal').serialize()+'&_token='+$('#token').val(),
            type: 'post',
            dataType: 'json',
            success: function(response){
                $("#"+$("#idItemModal").val()).val(response.item);
                $("#itemModal").modal('hide');
            }
        });
      });
    });
  </script>
@endsection
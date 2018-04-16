@if(Session::get('faseActual') != 'firmaelectronica')
<h2>{{ $sidebar[Session::get('faseActual')]['nombre'] }}</h2>
<form class="form-horizontal" id="form" accept-charset="UTF-8" method="post" action="{{ url('/gfsvte')}}" role="form">
    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
    @foreach($definicion as $key=>$item)
      @if(isset($item['encabezado']))
        <hr>
        <div class="form-group">
          <div class="col-lg-8">
            <label><strong>{{ $item['encabezado'] }}</strong></label>
          </div>      
        </div>
      @endif
      @if($item['tipo'] != 'container')
        @php ($valor = Session::get(Session::get('faseActualDatos').'.'.$key)) @endphp
        @php ($valor = (isset($item['arrayContainer']))?$valor[0]:$valor) @endphp
        @if($item['tipo'] == 'label')
          <div class="form-group">
            <div class="col-lg-8">
              <label for="{{ $key }}">
                @if(!isset($item['tag']) or !$item['tag'])
                @else
                <strong>{{ $item['nombre'] }}</strong>
                @endif
                {{ $valor }}
              </label>
            </div>      
          </div>
        @else
          @if($item['tipo'] == 'select')
            <div class="form-group">
              <div class="col-lg-8">
                <label for="{{ $key }}">{{ $item['nombre'] }}</label>
              </div>
              <div class="col-lg-6">
                @if(isset($itemID))
                  @php ($selectID = rand(1000000000,9999999999)) @endphp
                  <script type="text/javascript">
                    $(document).ready(function(){
                      $('#{{$itemID}}').change(function(){
                        $('#{{$selectID}}').empty();
                        var params = {};
                        params['_token'] = $("#token").val();
                        params['v'] = '{{ $key }}';
                        params['i'] = $(this).val();
                        $.ajax({
                          url: '{{ url("/bind") }}',
                          data: params,
                          type: 'post',
                          dataType: 'json',
                          success: function(response){
                            $.each(response,function(k,i){
                              $('#{{$selectID}}').append('<option value="'+i+'">'+i+'</option>')
                            });
                          }
                        });
                      });
                    })
                  </script>
                  <?php unset($itemID); ?>
                @endif
                @if(isset($item['bind']))
                  @php 
                    $itemID = rand(1000000000,9999999999);
                    $selectID = $itemID;
                  @endphp
                @endif
                <select {!! isset($selectID)?'id="'.$selectID.'"':''!!} class="form-control {{ $item['tipo'] }}" type="text" name="{{ $key }}">
                  @foreach($item['datos'] as $llave=>$opcion)
                    @php( $llave = trim($llave))
                    @if($valor == $llave)
                      @php ($selected = ' selected')
                    @else
                      @php ($selected = '')
                    @endif
                    <option value="{{ $llave }}" {{ $selected }}>{{ $opcion }}</option>
                  @endforeach  
                </select>
                <?php unset($selectID); ?>
              </div>
            </div>
          @else
            @if($item['tipo'] == 'textarea')
              <div class="form-group">
                <div class="col-lg-8">
                  <label for="{{ $key }}">{{ $item['nombre'] }}</label>
                </div>
                <div class="col-lg-6">
                  <textarea name="{{ $key }}" class="form-control {{ $item['tipo'] }}">{{ $valor }}</textarea>
                </div>
              </div>
            @else
              @if($item['tipo'] == 'upload')
                <hr>
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-12">
                      <label><strong>{{$item['nombre']}}</strong></label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <button class="btn btn-primary" id="buttonFileUpload_{{ $key }}">
                        <input id="fileupload_{{ $key }}" type="file" name="file" accept=".pdf, .zip" style="display: inline;">
                        Seleccionar Archivo
                      </button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th class="col-sm-3">%</th>
                            <th class="col-sm-7">Nombre</th>
                            <th class="col-sm-2">Eliminar</th>                           
                          </tr>
                        </thead>
                        <tbody id="file-upload-list-{{ $key }}" class="text-center">
                          @if(!empty(Session::get(Session::get('faseActualDatos').'.'.$key)))
                            @foreach(Session::get(Session::get('faseActualDatos').'.'.$key) as $document)
                            <tr>
                              <td>
                                <input type="hidden" id="documentsUrl" value="{{ isset($document['url']) ? $document['url'] : null }}">
                                <input type="hidden" id="nombreDocumento" value="{{ $document['originalName'] }}">
                                <input type="hidden" id="filePath" value="{{ $document['filePath'] }}">
                                <input type="hidden" id="code" value="{{ $document['code'] }}">
                                <input type="hidden" id="status" value="{{ json_encode($document['status']) }}">
                                <div class="progress">
                                  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="100" aria-valuemax="100" style="width:100%">100%</div>
                                </div>
                              </td>
                              <td>
                                <a target="_blank" href="{{ url('/getFile?file='.$document['filePath']) }}">
                                  {{ $document['originalName'] }}
                                </a>
                              </td>
                              <td>
                                <button type="button" class="btn btn-danger" onclick="deleteUpload{{ $key }}(this)">
                                  <span class="glyphicon glyphicon-trash"></span>
                                </button>
                              </td>
                            </tr>
                            @endforeach
                          @endif
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <script>
                  $(window).load(function() {
                    updateTable{{ $key }}();
                  });
                  function deleteUpload{{ $key }}(r){
                    var i = r.parentNode.rowIndex;
                    document.getElementById("file-upload-list-{{ $key }}").deleteRow(i);
                    var rowsCount = document.getElementById("file-upload-list-{{ $key }}").rows.length;
                    var countFalse = new Array();
                    for (var i =0; i < rowsCount; i++){
                      var x = document.getElementById('file-upload-list-{{ $key }}');
                      if(!x.rows[i].classList.contains('danger')){
                        var classTag = x.rows[i];
                        countFalse.push(x.rows[i].classList.contains('danger'));
                        for(var s = 0; s < countFalse.length; s++){
                          classTag.cells[0].getElementsByTagName('input')[0].setAttribute('name', '{{$key}}['+s+'][url]');
                          classTag.cells[0].getElementsByTagName('input')[1].setAttribute('name', '{{$key}}['+s+'][nombreDocumento]');
                        }
                      }
                    }
                  }
                  function updateTable{{ $key }}(){
                    var rowsCount = document.getElementById("file-upload-list-{{ $key }}").rows.length;
                    for (var i =0; i < rowsCount; i++){
                      var x = document.getElementById('file-upload-list-{{ $key }}');
                      console.log(x);
                      x.rows[i].cells[0].getElementsByTagName("input")[0].setAttribute('name', '{{$key}}['+i+'][url]');
                      x.rows[i].cells[0].getElementsByTagName("input")[1].setAttribute('name', '{{$key}}['+i+'][nombreDocumento]');
                      x.rows[i].cells[0].getElementsByTagName("input")[2].setAttribute('name', '{{$key}}['+i+'][filePath]');
                      x.rows[i].cells[0].getElementsByTagName("input")[3].setAttribute('name', '{{$key}}['+i+'][code]');
                      x.rows[i].cells[0].getElementsByTagName("input")[4].setAttribute('name', '{{$key}}['+i+'][status]');
                    }
                  }
                  function updateErroTable{{ $key }}(){
                    var rowsCount = document.getElementById("file-upload-list-{{ $key }}").rows.length;
                    var countFalse = new Array();
                    for (var i =0; i < rowsCount; i++){
                      var x = document.getElementById('file-upload-list-{{ $key }}');
                      if(!x.rows[i].classList.contains('danger')){
                        var classTag = x.rows[i];
                        countFalse.push(x.rows[i].classList.contains('danger'));
                        for(var s = 0; s < countFalse.length; s++){
                          classTag.cells[0].getElementsByTagName('input')[0].setAttribute('name', '{{$key}}['+s+'][url]');
                          classTag.cells[0].getElementsByTagName('input')[1].setAttribute('name', '{{$key}}['+s+'][nombreDocumento]');
                        }
                      }
                    }
                  }
                  $(document).ready(function(){
                    var fileUpload = $('#fileupload_{{ $key }}');
                    var uploadList = $('#file-upload-list-{{ $key }}');
                    var buttonFile = $('#buttonFileUpload_{{ $key }}');
                    var filename, extension;
                    fileUpload.change(function(){
                      filename = $('#fileupload_{{ $key }}').val().replace(/C:\\fakepath\\/i, '');
                    });
                    var idSequence = 0;
                    $('#fileupload_{{ $key }}').fileupload({
                      url: "{{ env('API_UPLOAD') }}",
                      dataType: 'json',
                      autoUpload: true,
                      acceptFileTypes: /(\.|\/)(pdf|zip)$/i,
                      maxFileSize: 25000000,
                      method: "POST"                      
                    }).on('fileuploadadd', function (e, data) {
                      $("#progressBar").css('width','0%');
                      $("#progressBar").html('0%');
                      $("#progressBar").addClass('progress-bar-striped');
                      idSequence++;
                      $('#buttonFileUpload_{{ $key }} input[name="file"]').attr("disabled", true);
                      buttonFile.attr("disabled", "disabled");
                      uploadList.append('<tr id="subiendo"><td><div class="progress"><div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">0%</div></div></td></tr>');
                    }).on('fileuploadprocessalways', function (e, data) {                      
                      var index = data.index, file = data.files[index];
                      if (file.error) {
                        $('#buttonFileUpload_{{ $key }} input[name="file"]').removeAttr("disabled");
                        buttonFile.removeAttr("disabled");
                        $('#file-upload-list-{{ $key }} #subiendo').remove();
                        uploadList.append('<tr class="danger"><td><span>'+file.error+'</span></td><td>'+file.name+'</td><td><button type="button" class="btn btn-danger" onclick="deleteUpload{{ $key }}(this)"><span class="glyphicon glyphicon-trash"></span></button></td></tr>');
                        updateErroTable{{ $key }}();
                      }
                    }).on('fileuploadprogressall', function (e, data) {
                      var progress = parseInt(data.loaded / data.total * 100, 10);
                      $("#progressBar").css('width',progress+'%');
                      $("#progressBar").html(progress+'%');
                    }).on('fileuploaddone', function (e, data) {
                      $('#buttonFileUpload_{{ $key }} input[name="file"]').removeAttr("disabled");
                      buttonFile.removeAttr("disabled");
                      $('#file-upload-list-{{ $key }} #subiendo').remove();
                      $("#progressBar").removeClass('progress-bar-striped');
                      uploadList.append('<tr id="'+idSequence+'"><td><input type="hidden" id="documentsUrl" value="'+data.result.path + data.result.name+'"><input type="hidden" id="nombreDocumento" value="'+filename+'"><div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="100" aria-valuemax="100" style="width:100%">100%</div></div></td><td>'+filename+'</td><td><button type="button" class="btn btn-danger" onclick="deleteUpload{{ $key }}(this)"><span class="glyphicon glyphicon-trash"></span></button></td></tr>');
                      updateErroTable{{ $key }}();
                    }).prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled');
                  });
                </script>
              @else
                @if($item['tipo'] == 'number')
                  <div class="form-group">
                    <div class="col-lg-8">
                      <label for="{{ $key }}">{{ $item['nombre'] }}</label>
                    </div>
                    <div class="col-lg-6">
                      <input class="form-control {{ $item['tipo'] }}" value="{{ $valor }}" type="text" step="1" min="0" oninput="this.value=this.value.replace(/[^\d]/g, '')" name="{{ $key }}" placeholder="ingrese {{ $item['nombre'] }}">
                    </div>
                  </div>
                @else
                  @if($item['tipo'] == 'null')
                    <input class="form-control {{ $item['tipo'] }}" type="hidden" 
                           value="null" 
                           name="{{ $key }}" placeholder="Ingrese {{ lcfirst(mb_strtolower($item['nombre'])) }}">
                  @else
                    @if($valor != '')
                      @php($valor = ($item['tipo']=='date')?date('d-m-Y',strtotime($valor)):$valor)
                    @endif
                    <div class="form-group">
                      <div class="col-lg-8">
                        <label for="{{ $key }}">{{ $item['nombre'] }}</label>
                      </div>
                      <div class="col-lg-6">
                        <input class="form-control {{ $item['tipo'] }}" type="text" 
                               value="{{ (isset($item['default']))?$item['default']:$valor }}" 
                               name="{{ $key }}" placeholder="Ingrese {{ lcfirst(mb_strtolower($item['nombre'])) }}">
                      </div>
                    </div>
                  @endif
                @endif
              @endif
            @endif
          @endif
        @endif
      @else
        @if(!$item['unico'] || (isset($item['modalContainer']) && $item['modalContainer']))
          @if(!$item['unico'])
            <div class="agrega">
              <a id="{{ $key }}" href="#" class="agregaItem">
                <i class="fa fa- fa-plus-square"></i><label>Agregar {{ isset($item['addLabel'])?$item['addLabel']:$key }}</label>
              </a>
            </div>
          @endif
          <div class="form-group">
            <table style="{{ isset($item['footer'])? "margin-bottom: 0px;": '' }}" id="tabla-{{ $key }}" class="table table-striped table-bordered">
            <thead>
            <tr>
              @foreach($item['th'] as $k=>$th)
                @if($k !== 'index')
                  <th>{{ $th }}</th>
                @endif
              @endforeach
              <th></th>
            </tr>
            </thead>
            <tbody>
              @php ($i=0)

              @if(isset($item['footer']))
                @php ($sum = 0)
              @endif

              @if(!\Session::has(\Session::get('faseActualDatos').'.'.$key))
                <tr> 
                  @foreach($item['detalle'] as $ktd => $td)
                    @if($td['tipo'] !== 'index')
                      <td {!!($td['tipo'] == 'modal')?'align="center"':''!!}>
                        @if($td['tipo'] == 'textarea')
                          <textarea name="{{ $key }}[{{$i}}][{{ $ktd }}]" class="form-control {{ $td['tipo'] }}"></textarea>
                        @else
                          @if($td['tipo'] == 'select')
                            <select class="form-control {{ $td['tipo'] }}" name="{{ $key }}[{{$i}}][{{ $ktd }}]">
                              @foreach($td['datos'] as $llave=>$opcion)
                                <option value="{{ $llave }}">{{ $opcion }}</option>
                              @endforeach
                            </select>
                          @else
                            @if($td['tipo'] == 'modal')
                              
                              <button class="btn btn-primary glyphicon glyphicon-pencil agregaItemModal">
                                <input type="hidden" class="itemModalLabel" value="{{$td['nombre']}}">
                                <input type="hidden" class="itemModalId" value="{{($item['unico'])?$key.'.'.$ktd:$key.'.'.$i.'.'.$ktd}}">
                                <input type="hidden" class="itemModalToken" id="{{ ($item['unico'])?$key .'-'. $ktd:$key .'-'.$i.'-'. $ktd }}" value=""
                                       name="{{ ($item['unico'])?$key .'['. $ktd .']':$key .'['.$i.']['. $ktd .']' }}">
                              </button>
                            @else
                              <input class="form-control {{ $td['tipo'] }}" type="text" name="{{ ($item['unico'])?$key . '['. $ktd .']': $key .'['.$i.']['. $ktd .']' }}" >
                            @endif
                          @endif
                        @endif
                      </td>
                    @endif
                  @endforeach
                  <td align="center">
                  </td>
                </tr>
              @else 
                @if(isset($item['modalContainer']) && $item['modalContainer'])
                  @if($item['unico'])
                    <tr>
                    @foreach(Session::get(Session::get('faseActualDatos').'.'.$key) as $muKey=>$modalUnico)
                      
                      @if($item['detalle'][$muKey]['tipo']=='modal')
                        <td align="center">
                        <button class="btn btn-primary glyphicon glyphicon-pencil agregaItemModal">
                          <input type="hidden" class="itemModalLabel" value="{{$item['detalle'][$muKey]['nombre']}}">
                          <input type="hidden" class="itemModalId" value="{{$key.'.'.$muKey}}">
                          <input type="hidden" class="itemModalToken" id="{{ $key .'-'. $muKey }}" name="{{ $key .'['. $muKey .']' }}"
                                 value="{{base64_encode(json_encode($modalUnico))}}">
                        </button>
                      @else
                        <td>
                        <input class="form-control {{ $item['detalle'][$muKey]['tipo'] }}" type="text" name="{{ $key .'['. $muKey .']' }}">

                      @endif  

                      </td>
                    @endforeach
                    </tr>
                  @else
                    @foreach(Session::get(Session::get('faseActualDatos').'.'.$key) as $mMKey=>$modalMulti)
                      <tr>
                        @foreach($item['detalle'] as $mKey=>$modal)
                          @if($modal['tipo']=='modal')
                            <td align="center">
                            <button class="btn btn-primary glyphicon glyphicon-pencil agregaItemModal">
                              <input type="hidden" class="itemModalLabel" value="{{$modal['nombre']}}">
                              <input type="hidden" class="itemModalId" value="{{$key.'.'.$mMKey.'.'.$mKey}}">
                              <input type="hidden" class="itemModalToken" id="{{ $key .'-'. $mMKey.'-'.$mKey }}" name="{{ $key .'['. $mMKey .']['.$mKey.']' }}"
                                     value="{{base64_encode(json_encode($modalMulti[$mKey]))}}">
                            </button>
                          @else
                            <td>
                            <input class="form-control {{ $modal['tipo'] }}" type="text" name="{{ $key .'['. $mMKey .']['.$mKey.']' }}">

                          @endif  

                          </td>
                        @endforeach
                      </tr>
                    @endforeach
                  @endif
                  
                @else
                  @foreach(Session::get(Session::get('faseActualDatos').'.'.$key) as $valor)
                    <tr>
                      @foreach($item['detalle'] as $ktd => $td)
                        @if($td['tipo']!='index')
                          @if(isset($td['objectContainer']))
                            @php($valor[$ktd]=$valor[$td['objectContainer']][$ktd])
                          @endif
                          <td>
                            @if($td['tipo'] == 'textarea')
                            <textarea name="{{ $key }}[{{$i}}][{{ $ktd }}]" class="form-control {{ $td['tipo'] }}">{{ $valor[$ktd] }}</textarea>
                            @else
                              @if($td['tipo'] == 'select')
                                <select class="form-control {{ $td['tipo'] }}" name="{{ $key }}[{{$i}}][{{ $ktd }}]">
                                  @foreach($td['datos'] as $llave=>$opcion)
                                    @if($valor[$ktd] == $llave)
                                      @php ($selected = ' selected')
                                    @else
                                      @php ($selected = '')
                                    @endif
                                    <option value="{{ $llave }}" {{ $selected }}>{{ $opcion }}</option>
                                  @endforeach
                                </select>
                              @else
                                <input class="form-control {{ $td['tipo'] }} {{ (isset($item['footer']) && $ktd=='montoConIVA')?'calendario-total':'' }}" value="{{ $valor[$ktd] }}" type="text" name="{{ $key }}[{{$i}}][{{ $ktd }}]">
                              @endif
                            @endif
                          </td>
                        @endif
                      @endforeach
                      @if(isset($item['footer']) )
                        @php ($sum += $valor['montoConIVA'] )
                      @endif
                      <td align="center">
                        @if($i>0)
                          <button type="button" class="btn btn-danger btn-delItem">
                            <span class="glyphicon glyphicon-trash"></span>
                          </button>
                        @endif
                      </td>
                    </tr>
                    @php ($i++)
                  @endforeach
                @endif
              @endif
              
            </tbody>
            </table>
            @if(isset($item['footer']))
              <table style="" class="table table-striped table-bordered">
              <tbody>
                <tr>
                  <td style="padding-right: 15%;" align="right">
                    <strong>Total:</strong> $<span id="calendario-total">{{ number_format($sum,'2','.',',') }}</span>
                  </td>
                </tr>
              <tbody>
              </table>
            @endif
          </div>
        @else
          @if(isset($item['tabla']))
            <div class="form-group">
              <table class="table table-striped table-bordered">
              <thead>
              <tr>
                @foreach($item['th'] as $th)
                  <th>{{ $th }}</th>
                @endforeach
              </tr>
              </thead>
              <tbody>
                @foreach($item['filas'] as $idFila=>$fila)
                  <tr>
                    <td>
                        {{ $fila }}
                    </td>
                    @foreach($item['detalle'] as $idTd=>$td)
                      <td>
                        @if($td['tipo'] == 'select')
                          <select class="form-control {{ $div['tipo'] }}" name="{{ $key }}[{{ $kdiv }}]">
                            @foreach($div['datos'] as $llave=>$opcion)
                              @if(\Session::get(\Session::get('faseActualDatos').'.'.$key.'.'.$idFila.'.'.$idTd ) == $llave)
                                @php ($selected = ' selected')
                              @else
                                @php ($selected = '')
                              @endif
                              <option value="{{ $llave }}" {{ $selected }}>{{ $opcion }}</option>
                            @endforeach
                          </select>
                        @else
                          <input class="form-control  {{ $td['tipo'] }}" type="text" 
                                 value="{{ \Session::get(\Session::get('faseActualDatos').'.'.$key.'.'.$idFila.'.'.$idTd ) }}"
                                 name="{{ $key }}[{{ $idFila }}][{{ $idTd}}]" placeholder="ingrese {{ $td['nombre'] }}">
                        @endif
                      </td>
                    @endforeach
                  </tr>
                @endforeach
              </tbody>
              </table>
            </div>
          @else
            @foreach($item['detalle'] as $kdiv => $div)
              @php ($valor = \Session::get('faseActualDatos').'.'.$key.'.')
              @if(isset($div['objectContainerData']))
                @php ($valor .= $div['objectContainerData'].'.'.$kdiv)
              @else
                @php ($valor .= (isset($div['objectContainer']))?$div['objectContainer'].'.'.$kdiv:$kdiv)
              @endif
              <div class="form-group">
                <div class="col-lg-8">
                  <label for="{{ $key }}">{{ $div['nombre'] }}</label>
                </div>
                <div class="col-lg-6"> 
                  @if($div['tipo'] == 'select')
                    <select class="form-control {{ $div['tipo'] }}" name="{{ $key }}[{{ $kdiv }}]">
                      @foreach($div['datos'] as $llave=>$opcion)
                        @if(\Session::get($valor) == $llave)
                          @php ($selected = ' selected')
                        @else
                          @php ($selected = '')
                        @endif
                        <option value="{{ $llave }}" {{ $selected }}>{{ $opcion }}</option>
                      @endforeach
                    </select>
                  @elseif($div['tipo'] == 'textarea')
                    <textarea name="{{ $key }}[{{ $kdiv }}]" class="form-control {{ $div['tipo'] }}">{{ \Session::get($valor) }}</textarea>  
                  @elseif($div['tipo'] == 'number')
                    <input class="form-control {{ $div['tipo'] }}" value="{{ \Session::get($valor) }}" type="number" step="1" min="0" oninput="this.value=this.value.replace(/[^\d]/g, '')" name="{{ $key }}[{{ $kdiv }}]" placeholder="ingrese {{ $div['nombre'] }}">
                  @elseif($div['tipo'] == 'container')
                    @if(!$item['detalle']['pasajes']['unico'] || (isset($item['detalle']['pasajes']['modalContainer']) && $item['detalle']['pasajes']['modalContainer']))
                      @if(!$item['detalle']['pasajes']['unico'])
                        <div class="agrega">
                          <a id="{{ $item['detalle']['pasajes']['nombre'] }}" href="#" class="agregaItem">
                            <i class="fa fa- fa-plus-square"></i><label>Agregar {{ isset($item['addLabel'])?$item['addLabel']:$item['detalle']['pasajes']['nombre'] }}</label>
                          </a>
                        </div>
                      @endif
                      <div class="form-group">
                        <table style="{{ isset($item['detalle']['pasajes']['footer'])? "margin-bottom: 0px;": '' }}" id="tabla-{{ $item['detalle']['pasajes']['nombre'] }}" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              @foreach($item['detalle']['pasajes']['th'] as $k=>$th)
                                @if($k !== 'index')
                                  <th>{{ $th }}</th>
                                @endif
                              @endforeach
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            @php ($i=0)
                            @if(isset($item['detalle']['pasajes']['footer']))
                              @php ($sum = 0)
                            @endif
                            @if(!\Session::has(\Session::get('faseActualDatos').'.'.$item['detalle']['pasajes']['nombre']))
                              <tr> 
                                @foreach($item['detalle']['pasajes']['detalle'] as $ktd => $td)
                                  @if($td['tipo'] !== 'index')
                                    <td {!!($td['tipo'] == 'modal')?'align="center"':''!!}>
                                      @if($td['tipo'] == 'textarea')
                                        <textarea name="{{ $key }}[{{$i}}][{{ $ktd }}]" class="form-control {{ $td['tipo'] }}"></textarea>
                                      @else
                                        @if($td['tipo'] == 'select')
                                          @php ($keyPas = $item['detalle']['pasajes']['nombre'])
                                          <select class="form-control {{ $td['tipo'] }}" name="{{ $key }}[{{ $keyPas }}][{{$i}}][{{ $ktd }}]">
                                            @foreach($td['datos'] as $llave=>$opcion)
                                              <option value="{{ $llave }}">{{ $opcion }}</option>
                                            @endforeach
                                          </select>
                                        @else
                                          @if($td['tipo'] == 'modal')
                                            
                                            <button class="btn btn-primary glyphicon glyphicon-pencil agregaItemModal">
                                              <input type="hidden" class="itemModalLabel" value="{{$td['nombre']}}">
                                              <input type="hidden" class="itemModalId" value="{{($item['unico'])?$key.'.'.$ktd:$key.'.'.$i.'.'.$ktd}}">
                                              <input type="hidden" class="itemModalToken" id="{{ ($item['unico'])?$key .'-'. $ktd:$key .'-'.$i.'-'. $ktd }}" value=""
                                                     name="{{ ($item['unico'])?$key .'['. $ktd .']':$key .'['.$i.']['. $ktd .']' }}">
                                            </button>
                                          @else
                                            <input class="form-control {{ $td['tipo'] }}" type="text" 
                                                   name="{{ ($item['detalle']['pasajes']['unico'])?$key . '['. $keyPas .']' . '['. $ktd .']':$key .'['.$keyPas.']['.$i.']['. $ktd .']' }}" 
                                                   placeholder="ingrese {{ isset($td['nombre'])?$td['nombre']:$ktd }}">
                                          @endif
                                        @endif
                                      @endif
                                    </td>
                                  @endif
                                @endforeach
                                <td align="center">
                                </td>
                              </tr>
                            @else 
                              @if(isset($item['detalle']['pasajes']['modalContainer']) && $item['detalle']['pasajes']['modalContainer'])
                                @if($item['detalle']['pasajes']['unico'])
                                  <tr>
                                  @foreach(Session::get(Session::get('faseActualDatos').'.'.$key) as $muKey=>$modalUnico)
                                    @if($item['detalle'][$muKey]['tipo']=='modal')
                                      <td align="center">
                                      <button class="btn btn-primary glyphicon glyphicon-pencil agregaItemModal">
                                        <input type="hidden" class="itemModalLabel" value="{{$item['detalle'][$muKey]['nombre']}}">
                                        <input type="hidden" class="itemModalId" value="{{$key.'.'.$muKey}}">
                                        <input type="hidden" class="itemModalToken" id="{{ $key .'-'. $muKey }}" name="{{ $key .'['. $muKey .']' }}"
                                               value="{{base64_encode(json_encode($modalUnico))}}">
                                      </button>
                                    @else
                                      <td>
                                      <input class="form-control {{ $item['detalle'][$muKey]['tipo'] }}" type="text" 
                                             name="{{ $key .'['. $muKey .']' }}" 
                                             placeholder="ingrese {{$item['detalle'][$muKey]['nombre']}}" value="{{$modalUnico}}">

                                    @endif  
                                    </td>
                                  @endforeach
                                  </tr>
                                @else
                                  @foreach(Session::get(Session::get('faseActualDatos').'.'.$key) as $mMKey=>$modalMulti)
                                    <tr>
                                      @foreach($item['detalle'] as $mKey=>$modal)
                                        @if($modal['tipo']=='modal')
                                          <td align="center">
                                          <button class="btn btn-primary glyphicon glyphicon-pencil agregaItemModal">
                                            <input type="hidden" class="itemModalLabel" value="{{$modal['nombre']}}">
                                            <input type="hidden" class="itemModalId" value="{{$key.'.'.$mMKey.'.'.$mKey}}">
                                            <input type="hidden" class="itemModalToken" id="{{ $key .'-'. $mMKey.'-'.$mKey }}" name="{{ $key .'['. $mMKey .']['.$mKey.']' }}"
                                                   value="{{base64_encode(json_encode($modalMulti[$mKey]))}}">
                                          </button>
                                        @else
                                          <td>
                                          <input class="form-control {{ $modal['tipo'] }}" type="text" 
                                                 name="{{ $key .'['. $mMKey .']['.$mKey.']' }}" 
                                                 placeholder="ingrese {{$modal['nombre']}}" value="{{$modalMulti[$mKey]}}">

                                        @endif  

                                        </td>
                                      @endforeach
                                    </tr>
                                  @endforeach
                                @endif
                              @else
                                @foreach(Session::get(Session::get('faseActualDatos').'.'.$key) as $valor)
                                  <tr>
                                    @foreach($item['detalle']['pasajes']['detalle'] as $ktd => $td)
                                      @if($td['tipo']!='index')
                                        @if(isset($td['objectContainer']))
                                          @php($valor[$ktd]=$valor[$td['objectContainer']][$ktd])
                                        @endif
                                        <td>
                                          @if($td['tipo'] == 'textarea')
                                          <textarea name="{{ $key }}[{{$i}}][{{ $ktd }}]" class="form-control {{ $td['tipo'] }}">{{ $valor[$ktd] }}</textarea>
                                          @else
                                            @if($td['tipo'] == 'select')
                                              <select class="form-control {{ $td['tipo'] }}" name="{{ $key }}[{{$i}}][{{ $ktd }}]">
                                                @foreach($td['datos'] as $llave=>$opcion)
                                                  @if($valor[$ktd] == $llave)
                                                    @php ($selected = ' selected')
                                                  @else
                                                    @php ($selected = '')
                                                  @endif
                                                  <option value="{{ $llave }}" {{ $selected }}>{{ $opcion }}</option>
                                                @endforeach
                                              </select>
                                            @else
                                              <input class="form-control {{ $td['tipo'] }} {{ (isset($item['footer']) && $ktd=='montoConIVA')?'calendario-total':'' }}"       
                                                     value="{{ $valor[$ktd] }}" type="text" 
                                                     name="{{ $key }}[{{$i}}][{{ $ktd }}]" placeholder="ingrese {{ isset($td['nombre'])?$td['nombre']:$ktd }}">
                                            @endif
                                          @endif
                                        </td>
                                      @endif
                                    @endforeach
                                    @if(isset($item['detalle']['pasajes']['footer']) )
                                      @php ($sum += $valor['montoConIVA'] )
                                    @endif
                                    <td align="center">
                                      @if($i>0)
                                        <button type="button" class="btn btn-danger btn-delItem">
                                          <span class="glyphicon glyphicon-trash"></span>
                                        </button>
                                      @endif
                                    </td>
                                  </tr>
                                  @php ($i++)
                                @endforeach
                              @endif
                            @endif
                          </tbody>
                        </table>
                        @if(isset($item['detalle']['pasajes']['footer']))
                          <table style="" class="table table-striped table-bordered">
                          <tbody>
                            <tr>
                              <td style="padding-right: 15%;" align="right">
                                <strong>Total:</strong> $<span id="calendario-total">{{ number_format($sum,'2','.',',') }}</span>
                              </td>
                            </tr>
                          <tbody>
                          </table>
                        @endif
                      </div>
                    @endif
                  @else
                    @if(!is_null(Session::get($valor)))
                      @php($valor = ($div['tipo']=='date')?date('d-m-Y',strtotime(Session::get($valor))):Session::get($valor))
                    @else
                      @php ($valor = '')
                    @endif
                    <input class="form-control {{ $div['tipo'] }}" type="text" value="{{ isset($div['default'])?$div['default']:$valor }}" name="{{ $key }}[{{ $kdiv }}]" placeholder="Ingrese {{ $div['nombre'] }}">
                  @endif
                </div>
              </div>
            @endforeach
          @endif
        @endif
      @endif
    @endforeach    
    @if(!isset($item['tag']) or !$item['tag'])
      <div class="form-group">
        <div class="col-lg-2">
          <input id="envio" type="submit" value="Guardar">
        </div>
        @if($sidebar[Session::get('faseActual')]['array'])
          <div class="col-lg-2">
            <a href="{{url('/cancelFicha')}}" class="btn btn-primary">Cancelar</a>
          </div>
        @endif
      </div>
    @endif
</form>
@else
  <h2>{{ $sidebar[Session::get('faseActual')]['nombre'] }}</h2>
  <form class="form-horizontal" target="_blank" id="form" accept-charset="UTF-8" method="post" action="{{ url('/svte/firmaelectronica/generaPDF') }}" role="form" enctype="multipart/form-data">
    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">   
    @foreach($definicion as $key=>$item)
      
      @if($item['tipo'] == 'label')
        <div class="form-group">
          <div class="col-lg-8">
            <label for="{{ $key }}">
              @if(!isset($item['tag']) or !$item['tag'])

              <strong>Ingrese los datos</strong>&nbsp;&nbsp;
              @else
              <strong>No se ha completado el registro</strong>
              @endif

              {{ Session::get('fase.'.Session::get('faseActual').'.'.$key) }}
            </label>
          </div>      
        </div>
      @elseif($item['tipo'] == 'cer')
        <div class="form-group">
          <div class="col-lg-8">
            <label for="{{ $key }}">{{ $item['nombre'] }}</label>
          </div>
          <div class="col-lg-9 espaciado">
            <div class="col-lg-3">
              <a class="btn btn-primary btn-file">
                Selecciona archivo
                <input accept=".cer" type="file" name="cer" id="cer" onchange="$('#upload-cert').html($(this).val());">
              </a>
            </div>
            <div class="col-lg-3">
              <span class="label label-default upload-span" id="upload-cert">&nbsp;</span>
            </div>
          </div>
        </div>
        @elseif($item['tipo'] == 'key')
        <div class="form-group">
          <div class="col-lg-8">
            <label for="{{ $key }}">{{ $item['nombre'] }}</label>
          </div>
          <div class="col-lg-9 espaciado">
            <div class="col-lg-3">
              <a class="btn btn-primary btn-file">
                Selecciona archivo
                <input accept=".key" type="file" name="key" id="key" onchange="$('#upload-key').html($(this).val());">
              </a>
            </div>
            <div class="col-lg-3">
              <span class="label label-default upload-span" id="upload-key">&nbsp;</span>
            </div>
          </div>
        </div>
        @elseif($item['tipo'] == 'password')
        
        <div class="form-group">
          <div class="col-lg-8">
            <label for="{{ $key }}">{{ $item['nombre'] }}</label>
          </div>
          <div class="col-lg-6">
            
            <input class="form-control {{ $item['tipo'] }}" type="password" 
              name="{{ $key }}" placeholder="{{ $item['nombre'] }}">
                  
          </div>
        </div>  
      @endif
        
    @endforeach

    @if(!isset($item['tag']) or !$item['tag'])  
      <div class="form-group">
        <div class="col-lg-9">
          <input id="" type="submit" value="Guardar">
        </div>
      </div>
      
    @endif
  </form>
@endif
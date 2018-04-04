@extends('pdf.master2')

@section('detalle')
<div style="width:100%; display: block; padding: 0% 0% 0% 0%">
  <div style="width:100%; display: block; padding: 0% 0% 0% 0%">
    <table class="tg2">
      <tr>
        <td colspan="15" valign="middle" style="border-right-width:1px; border-bottom-width: 1px; border-top-width: 0px; font-size:18px; text-align:justify; padding: 0% 0% 0% 0%;">
          <fieldset>
            <legend><strong><span style="background: #EEECEC;">Datos de la comisión.</span></strong></legend>
            <table width="608" border="0" align="center" style="padding: 0% 0% 0% 1%">
              <tbody>
                <tr>
                  <td width="auto" colspan="2" style="border-left-width:0px; border-right-width:0px; font-size:15px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px; text-align:left;"><span style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:15px; text-align:left;"><strong>Tipo:</strong></span>&nbsp;<span style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:15px; text-align:left; text-transform: capitalize;">{{ $detalleComision['nombre'] }}</span></td>
                  <td width="auto" colspan="2" style="border-left-width:0px; border-right-width:0px; font-size:7px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px; text-align:left;"><span style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:15px; text-align:left;"><strong>Folio:</strong></span>&nbsp;<span style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:15px; text-align:left;">{{ $folio }}</span></td>
                  <td width="auto" colspan="4" style="border-left-width:0px; border-right-width:0px; font-size:7px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px; text-align:left;"><span style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:15px; text-align:left;"><strong>Fecha de creación:</strong></span>&nbsp;<span style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:15px; text-align:left;">{{ $created }}</span></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td width="270" colspan="5" style="border-left-width:0px; border-right-width:0px; font-size:15px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px; text-align:left;"><p style="text-align: justify;"><span style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:15px; text-align:left;"><strong>Nombre de la Comisión:</strong></span>&nbsp;<span style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:15px; text-align:left;">{{ $detalleComision['nomComision'] }}</p></span></td>
                  <td width="270" colspan="5" style="border-left-width:0px; border-right-width:0px; font-size:7px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px; text-align:left;"><p style="text-align: justify;"><span style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:15px; text-align:left;"><strong>Organizador del Evento:</strong></span>&nbsp;<span style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:15px; text-align:left;">{{ $detalleComision['orgEvento'] }}</p></span></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="11" style="border-left-width:0px; border-right-width:0px; font-size:15px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px; padding: 0% 0% 1% 0%; text-align:left;"><strong>Origen-Destino:</strong>&nbsp; {{ $registroPersonalNacional['comisionados'][0]['saliendoEstadoNacional'] }}<strong>&nbsp;-&nbsp;</strong>{{ $registroPersonalNacional['comisionados'][0]['saliendoMunicipioNacional'] }}<strong>&nbsp;/&nbsp;</strong>{{ $registroPersonalNacional['comisionados'][0]['llegandoEstadoNacional'] }}<strong>&nbsp;-&nbsp;</strong>{{ $registroPersonalNacional['comisionados'][0]['llegandoMunicipioNacional'] }}</td>
                </tr>
                <tr>
                  <td colspan="5" style="border-left-width:0px; border-right-width:0px; font-size:15px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px; padding: 0% 0% 1% 0%; text-align:left;"><span style="border-left-width:0px; border-right-width:0px; font-size:15px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px; padding: 0% 0% 0% 0%; text-align:left;"><strong>Periodo de Comisión:</strong></span><span style="border-left-width:0px; border-right-width:0px; font-size:15px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px; padding: 0% 0% 0% 0%; text-align:left;">{{ date_format(date_create($registroPersonalNacional['comisionados'][0]['dateSalida']),'d/m/Y') }}<strong>&nbsp;-&nbsp;</strong>{{ date_format(date_create($registroPersonalNacional['comisionados'][0]['dateRegreso']),'d/m/Y') }}</span></td>
                </tr>
                @if($detalleComision['link'] != null)
                <tr>
                  <td colspan="13" style="border-left-width:0px; border-right-width:0px; font-size:15px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px; padding: 0% 0% 1% 0%; text-align:left;"><p style="text-align: justify;"><span style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:15px; text-align:left;"><strong>Link del Evento:</strong></span>&nbsp;<span style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:15px; text-align:left;">{{ $detalleComision['link'] }}</span> </p>
                  </td>
                </tr>
                @endif                
                <tr>
                  <td style="border-left-width:0px; border-right-width:0px; font-size:15px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px; padding: 0% 0% 1% 0%; text-align:left;"><strong>Motivo:</strong></td>
                  <td colspan="13" style="border-left-width:0px; border-right-width:0px; font-size:15px; border-left-width:0px;  border-top-width:0px; border-bottom-width:0px; padding: 0% 11% 0% 2%; text-align:justify;">{{ $detalleComision['motivo'] }}</td> 
                </tr>
              </tbody>
            </table>
          </fieldset>
        </td>
      </tr>
      <tr>
        <td valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:14px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
        <td valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:14px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
        <td colspan="3" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:14px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
        <td valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:14px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
        <td valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:14px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
        <td valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:14px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
        <td valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:14px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
        <td valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:14px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
        <td colspan="2" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:14px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
        <td valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:14px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
        <td valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:14px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
        <td valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:14px; text-align:center; padding: 0% 0% 0% 0%;">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="15" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:20px; text-align:left; padding: 0% 0% 0% 1%;">&nbsp;</td>
      </tr>
      <tr>
       <td colspan="15" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:18px; text-align:left; padding: 0% 0% 0% 1%;"><strong style="background-color: #F5F5F5;">Comisionados</strong><hr/></td>
      </tr>
      @php
        $total = 0;
      @endphp    
      @foreach($registroPersonalNacional['comisionados'] as $key => $item)
        <tr>
          <td colspan="15" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:15px; text-align:left; padding: 0% 0% 0% 1%;"><strong>Nombre:</strong>&nbsp;{{ $item['nombres'] }}&nbsp;{{ $item['paterno'] }}&nbsp;{{ $item['materno'] }}</td>
        </tr>
        <tr>
          <td colspan="15" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:15px; text-align:left; padding: 0% 0% 0% 1%;"><strong>Denominación del Cargo:</strong>&nbsp;{{ $item['denominacionCargo'] }}<hr style="color: #ffffff; size=1;"/></td>
        </tr>
        <tr>
          <td colspan="15" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:3px; text-align:left; padding: 0% 0% 0% 1%;">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="10" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:15px; text-align:left; padding: 0% 0% 0% 1%;">Pasajes<hr style="color: #bababa; size=1;"/></td>
          <td colspan="5" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:15px; text-align:left; padding: 0% 0% 0% 1%;">Monto<hr style="color: #bababa; size=1;"/></td>
        </tr>
        @foreach($item['pasajes'] as $pitem)
          @php
            $total += $pitem['montoPasajes'];
          @endphp        
          <tr>
            <td colspan="10" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:15px; text-align:left; padding: 0% 0% 0% 1%;">{{ $pitem['pasajesPartida'] }}</td>
            <td colspan="5" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:15px; text-align:left; padding: 0% 0% 0% 1%;">{{ "$".number_format($pitem['montoPasajes'], 2) }}</td>
          </tr>
        @endforeach
        <?php
          $sum = 0;
          foreach ($item['pasajes'] as $gkey => $gvalue) {
            $sum += $gvalue['montoPasajes'];
          }
        ?>
        <tr>
          <td colspan="15" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:7px; text-align:left; padding: 0% 0% 0% 1%;">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="10" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:15px; text-align:left; padding: 0% 0% 0% 1%;">Viáticos<hr style="color: #bababa; size=1;"/></td>
          <td colspan="5" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:15px; text-align:left; padding: 0% 0% 0% 1%;">Monto<hr style="color: #bababa; size=1;"/></td>
        </tr>
        @foreach($item['viaticos'] as $vitem)
          @php 
            $total += $vitem['montoViaticos']
          @endphp        
          <tr>
            <td colspan="10" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:15px; text-align:left; padding: 0% 0% 0% 1%;">{{ $vitem['viaticosPartida'] }}</td>
            <td colspan="5" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:15px; text-align:left; padding: 0% 0% 0% 0%;">{{ "$".number_format($vitem['montoViaticos'], 2) }}</td>
          </tr>
        @endforeach
        <?php
          $suv = 0;
          foreach ($item['viaticos'] as $ukey => $uvalue) {
            $suv += $uvalue['montoViaticos'];
          }
          $subtotal = $sum + $suv; 
        ?>        
        <tr>
          <td colspan="15" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:10px; text-align:left; padding: 0% 0% 0% 1%;">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="10" valign="middle" style="font-size:14px; text-align:right;"><strong>subtotal de gasto por comisionados: </strong></td>
          <td colspan="5" valign="middle" style="font-size:15px; text-align:left;background-color: #E0E0E0;">{{ "$".number_format($subtotal, 2) }}</td>
        </tr>        
        <tr>
          <td colspan="15" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:6px; text-align:left; padding: 0% 0% 0% 1%;">&nbsp;<hr/></td>
        </tr>
        <tr>
          <td colspan="15" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:13px; text-align:left; padding: 0% 0% 0% 1%;">&nbsp;</td>
        </tr>
      @endforeach
      <tr style="background-color: #EEECEC;">
       <td colspan="10" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:16px; text-align:right; padding: 0% 2% 0% 1%;"><strong>Total de Gasto de Comisionados:</strong></td>
       <td colspan="5" valign="middle" style="border-right-width:0px; border-bottom-width: 0px; border-top-width: 0px; font-size:16px; text-align:left; padding: 0% 0% 0% 0%;"><strong>{{ "$".number_format($total, 2) }}</strong></td>
      </tr>
    </table>
  </div>
</div>
@endsection
<!DOCTYPE html>
<html lang="es">
<head>
  <title>Comisionados</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<table>
  <tbody>
    <tr>
      <td>Fecha de creación</td>
      <td>Folio</td>
      <td>Estatus</td>
      <td>Tipo de integrante del sujeto obligado</td>
      <td>Nivel de puesto</td>
      <td>Denominación del cargo (De conformidad con el nombramiento otorgado)</td>
      <td>Área de adscripción o Unidad Administrativa</td>
      <td>Nombre (s)</td>
      <td>Apellido Paterno</td>
      <td>Apellido Materno</td>
      <td>Nombre de la comisión</td>
      <td>Tipo de viático</td>
      <td style="background-color: #ff149b;color: #ffffff;font-weight: bold;">Continente de orígen</td>
      <td style="background-color: #ff149b;color: #ffffff;font-weight: bold;">País de orígen</td>
      <td style="background-color: #ff149b;color: #ffffff;font-weight: bold;">Estado de orígen</td>
      <td style="background-color: #ff149b;color: #ffffff;font-weight: bold;">Ciudad de orígen</td>
      <td style="background-color: #ff149b;color: #ffffff;font-weight: bold;">Continente de destino</td>
      <td style="background-color: #ff149b;color: #ffffff;font-weight: bold;">País de orígen</td>
      <td style="background-color: #ff149b;color: #ffffff;font-weight: bold;">Estado de orígen</td>
      <td style="background-color: #ff149b;color: #ffffff;font-weight: bold;">Ciudad de orígen</td>
      <td>Objetivo del comisionado</td>
      <td>Actividades</td>
      <td>Fecha de Salida</td>
      <td>Fecha de Regreso</td>
      <td>Pasajes</td>
      <td>Viáticos</td>
      <td>Gasto total</td>
      <?php
        $partidasPasajes = array(
          '3711 - Pasajes aéreos nacionales', 
          '3712 - Pasajes aéreos internacionales', 
          '3721 - Pasajes terrestres nacionales', 
          '3722 - Pasajes terrestres al interior del Distrito Federal', 
          '3723 - Traslado terrestre de personas',
          '3724 - Pasajes terrestres internacionales',
          '3751 - Viáticos en el país', 
          '3761 - Viáticos en el extranjero', 
          '3781 - Servicios integrales de traslado y viáticos', 
          '3791 - Otros servicios de traslado y hospedaje'
        );
      ?>
      <?php
        foreach ($partidasPasajes as $pNackey => $pNacvalue){
          echo '<td>'.$pNacvalue.'</td>';
        }      
      ?>
    </tr>
    @foreach($items as $key=>$value)
      @if($value['detalleComision']['nombre'] == 'nacional')
        @foreach($value['registroPersonalNacional']['comisionados'] as $nkey=>$nvalue)
          <tr>
            <td>{{ date_format(date_create($value['created']),'d/m/Y') }}</td>
            <td>{{ $value['folio'] }}</td>
            <td>{{ $value['status'] }} </td>
            <td>{{ $nvalue['tipoIntegrante'] }}</td>
            <td>{{ $nvalue['nivelPuesto'] }}</td>
            <td>{{ $nvalue['denominacionCargo'] }}</td>
            <td>{{ $nvalue['areaAdscripcion'] }}</td>
            <td>{{ $nvalue['nombres'] }}</td>
            <td>{{ $nvalue['paterno'] }}</td>
            <td>{{ $nvalue['materno'] }}</td>
            <td>{{ $value['detalleComision']['nomComision'] }}</td>
            <td>{{ ucfirst($value['detalleComision']['nombre']) }}</td>
            <td></td>            
            <td>MEX</td>            
            <td>{{ $nvalue['saliendoEstadoNacional'] }}</td>
            <td>{{ $nvalue['saliendoMunicipioNacional'] }}</td>
            <td></td>            
            <td>MEX</td>            
            <td>{{ $nvalue['llegandoEstadoNacional'] }}</td>
            <td>{{ $nvalue['llegandoMunicipioNacional'] }}</td>
            <td>{{ $nvalue['objetivoComisionado'] }}</td>
            <td>{{ $nvalue['actividadesRealizar'] }}</td>
            <td>{{ date_format(date_create($nvalue['dateSalida']),'d/m/Y') }}</td>
            <td>{{ date_format(date_create($nvalue['dateRegreso']),'d/m/Y') }}</td>
            <?php
              $sum = 0;
              $listNacPasajes = [];
              foreach ($nvalue['pasajes'] as $gkey => $gvalue) {
                $listNacPasajes[$gvalue['pasajesPartida']] = $gvalue['montoPasajes'];
                $sum += $gvalue['montoPasajes'];
              }
            ?>            
            <td style="text-align: center;">{{ $sum }}</td>
            <?php
              $suv = 0;
              $listNacViaticos = [];
              foreach ($nvalue['viaticos'] as $ukey => $uvalue) {
                $listNacViaticos[$uvalue['viaticosPartida']] = $uvalue['montoViaticos'];
                $suv += $uvalue['montoViaticos'];
              } 
            ?>               
            <td style="text-align: center;">{{ $suv }}</td>
            <td style="text-align: center;">{{ ($sum+$suv) }}</td>
            <?php
              list($a, $b, $c, $d, $e, $f, $g, $h, $i, $j) = $partidasPasajes;
              $aVal = array_key_exists($a, $listNacPasajes) ? ($listNacPasajes[$a]) : 0;
              $bVal = array_key_exists($b, $listNacPasajes) ? ($listNacPasajes[$b]) : 0;
              $cVal = array_key_exists($c, $listNacPasajes) ? ($listNacPasajes[$c]) : 0;
              $dVal = array_key_exists($d, $listNacPasajes) ? ($listNacPasajes[$d]) : 0;
              $eVal = array_key_exists($e, $listNacPasajes) ? ($listNacPasajes[$e]) : 0;
              $fVal = array_key_exists($f, $listNacPasajes) ? ($listNacPasajes[$f]) : 0;
              $gVal = array_key_exists($g, $listNacViaticos) ? ($listNacViaticos[$g]) : 0;
              $hVal = array_key_exists($h, $listNacViaticos) ? ($listNacViaticos[$h]) : 0;
              $iVal = array_key_exists($i, $listNacViaticos) ? ($listNacViaticos[$i]) : 0;
              $jVal = array_key_exists($j, $listNacViaticos) ? ($listNacViaticos[$j]) : 0;
              echo '<td style="text-align: center;">'.$aVal.'</td>';
              echo '<td style="text-align: center;">'.$bVal.'</td>';
              echo '<td style="text-align: center;">'.$cVal.'</td>';
              echo '<td style="text-align: center;">'.$dVal.'</td>';
              echo '<td style="text-align: center;">'.$eVal.'</td>';
              echo '<td style="text-align: center;">'.$fVal.'</td>';
              echo '<td style="text-align: center;">'.$gVal.'</td>';
              echo '<td style="text-align: center;">'.$hVal.'</td>';
              echo '<td style="text-align: center;">'.$iVal.'</td>';
              echo '<td style="text-align: center;">'.$jVal.'</td>';
            ?>
          </tr>
        @endforeach
      @else
        @foreach($value['registroPersonalInternacional']['comisionados'] as $ikey=>$ivalue)
          <tr>
            <td>{{ date_format(date_create($value['created']),'d/m/Y') }}</td>
            <td>{{ $value['folio'] }}</td>
            <td>{{ $value['status'] }} </td>
            <td>{{ $ivalue['tipoIntegrante'] }}</td>
            <td>{{ $ivalue['nivelPuesto'] }}</td>
            <td>{{ $ivalue['denominacionCargo'] }}</td>
            <td>{{ $ivalue['areaAdscripcion'] }}</td>
            <td>{{ $ivalue['nombres'] }}</td>
            <td>{{ $ivalue['paterno'] }}</td>
            <td>{{ $ivalue['materno'] }}</td>
            <td>{{ $value['detalleComision']['nomComision'] }}</td>
            <td>{{ ucfirst($value['detalleComision']['nombre']) }}</td>
            <td>{{ $ivalue['saliendoContinenteInternacional'] }}</td>
            <td>{{ $ivalue['saliendoPaisInternacional'] }}</td>
            <td>{{ $ivalue['saliendoEntidadInternacional'] }}</td>
            <td></td>
            <td>{{ $ivalue['llegandoContinenteInternacional'] }}</td>
            <td>{{ $ivalue['llegandoPaisInternacional'] }}</td>
            <td>{{ $ivalue['llegandoEntidadInternacional'] }}</td>
            <td></td>
            <td>{{ $ivalue['objetivoComisionado'] }}</td>
            <td>{{ $ivalue['actividadesRealizar'] }}</td>
            <td>{{ date_format(date_create($ivalue['dateSalida']),'d/m/Y') }}</td>
            <td>{{ date_format(date_create($ivalue['dateRegreso']),'d/m/Y') }}</td>
            <?php
              $sumi = 0;
              $listIntPasajes = [];
              foreach ($ivalue['pasajes'] as $gikey => $givalue) {
                $listIntPasajes[$givalue['pasajesPartida']] = $givalue['montoPasajes'];
                $sumi += $givalue['montoPasajes'];
              }
            ?>            
            <td style="text-align: center;">{{ $sumi }}</td>
            <?php
              $suvi = 0;
              $listIntViaticos = [];
              foreach ($ivalue['viaticos'] as $uikey => $uivalue) {
                $listIntViaticos[$uivalue['viaticosPartida']] = $uivalue['montoViaticos'];
                $suvi += $uivalue['montoViaticos'];
              } 
            ?>               
            <td style="text-align: center;">{{ $suvi }}</td>
            <td style="text-align: center;">{{ ($sumi+$suvi) }}</td>
            <?php
              list($a, $b, $c, $d, $e, $f, $g, $h, $i, $j) = $partidasPasajes;
              $aVal = array_key_exists($a, $listIntPasajes) ? ($listIntPasajes[$a]) : 0;
              $bVal = array_key_exists($b, $listIntPasajes) ? ($listIntPasajes[$b]) : 0;
              $cVal = array_key_exists($c, $listIntPasajes) ? ($listIntPasajes[$c]) : 0;
              $dVal = array_key_exists($d, $listIntPasajes) ? ($listIntPasajes[$d]) : 0;
              $eVal = array_key_exists($e, $listIntPasajes) ? ($listIntPasajes[$e]) : 0;
              $fVal = array_key_exists($f, $listIntPasajes) ? ($listIntPasajes[$f]) : 0;
              $gVal = array_key_exists($g, $listIntViaticos) ? ($listIntViaticos[$g]) : 0;
              $hVal = array_key_exists($h, $listIntViaticos) ? ($listIntViaticos[$h]) : 0;
              $iVal = array_key_exists($i, $listIntViaticos) ? ($listIntViaticos[$i]) : 0;
              $jVal = array_key_exists($j, $listIntViaticos) ? ($listIntViaticos[$j]) : 0;
              echo '<td style="text-align: center;">'.$aVal.'</td>';
              echo '<td style="text-align: center;">'.$bVal.'</td>';
              echo '<td style="text-align: center;">'.$cVal.'</td>';
              echo '<td style="text-align: center;">'.$dVal.'</td>';
              echo '<td style="text-align: center;">'.$eVal.'</td>';
              echo '<td style="text-align: center;">'.$fVal.'</td>';
              echo '<td style="text-align: center;">'.$gVal.'</td>';
              echo '<td style="text-align: center;">'.$hVal.'</td>';
              echo '<td style="text-align: center;">'.$iVal.'</td>';
              echo '<td style="text-align: center;">'.$jVal.'</td>';
            ?>
          </tr>          
        @endforeach     
      @endif
    @endforeach
  </tbody>
</table>

</html>
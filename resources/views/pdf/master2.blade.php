<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
</head>
  <style type="text/css">    
    @page { margin: 125px 23px 135px 23px; }
    #header { position: fixed; left: 0px; top: -85px; right: 0px; height: 80px; text-align: center;}
    #footer { position: fixed; left: 0px; bottom: -140px; right: 0px; height: 140px;}
    #footer .page:afeter { content: counter(page, upper-roman); }
    #header .page:afeter { content: counter(page, upper-roman); }
    .color{
      background-color: #666666;
      color: #ffffff;    
    }
    .tg  {border-collapse:collapse;border-spacing:0; width: 100%;}
    .tg td{font-family:Arial, sans-serif;font-size:8px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-top-width:1px;border-bottom-width:1px;}
    .tg th{font-family:Arial, sans-serif;font-size:8px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-top-width:1px;border-bottom-width:1px;}
    .tg2  {border: #ffffff 3px solid; width: 100%; border-collapse: collapse}
    
    .tg2 td{border-color: #ffffff; font-family:Arial, sans-serif;font-size:12px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-top-width:0px;border-bottom-width:0px;}
    .tg2 th{ border-color:#ffffff;font-family:Arial, sans-serif;font-size:12px;font-weight:normal;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-top-width:0px;border-bottom-width:0px;}
    .tg .tg-yw4l{vertical-align:top}
    .titulos_tabla{color:#666666 !important;}
    .lateralizq{border-left-width:1px !important;}
    .lateralder{border-right-width:1px !important;}
  </style>
<div id="header">
  <div>
     <div style="width:100%; margin-top: 8px;">
        <div style="text-align:left; float: left; width:29%; vertical-align: text-top"> <img src="assets/logotipos/cdmx_constancia.png" style="width:200px;"></div>
        <div style="text-align:left; font-size:10px; float: left; width:69%; vertical-align: text-top"></div>
     </div>
     <br>
     <br>
  </div>    
</div>
<div id="footer">
  <div>
    <div style="float: right;width: 320px;">
      <div style="text-align: right;position: relative;width: 230px;display: inline-block;font-family:Arial, sans-serif;line-height: auto;"><span style="font-size:11px;margin: 10px 0px;"><strong style="line-height: 15px;">Oficialía Mayor</strong></span><br><span style="font-size:10px;margin: 10px 0px;"><strong style="line-height: 11px;">Dirección Ejecutiva de Fortalecimiento Institucional y Gestión Interna</strong></span><br><span style="font-size: 9px; margin: 10px 0px;line-height: 11px;">Plaza de la Constitución No. 1 Tercer Piso, Col. Centro, Del. Cuauhtémoc, C.P. 06068.</span><br><span style="font-size: 9px;margin: 10px 0px;"><strong style="line-height: 13px;">www.om.cdmx.gob.mx</strong></span></div>
      <img src="assets/logotipos/om.jpg" width="25%" height="auto" style="text-align: right;position: relative; display: inline-block;">
</span>
    </div>
  </div>
</div>

<div id="content">
  @yield('detalle')
</div>
</html>
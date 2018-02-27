<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;

use App\Http\Requests;

class Utilidades extends Controller{

  public function muleConnection($type, $method, $port, $parameters = array(),$dataType = true){
		$client = new \GuzzleHttp\Client();
		$data = null;
		if($type != 'GET'){
			$data = [
        'headers' => ['Content-Type' => 'application/json'],
        'body'=>json_encode($parameters),
      ];
		}
		foreach(\App\Mules::getMules() as $mule){
			$url = 'http://'.$mule['ip'].':'.$port.$method;
			try{
				if(is_null($data)){
					$response = $client->request($type, $url);
				}else{
					$response = $client->request($type, $url, $data);
				}
				if($response->getStatusCode() == 200){
          switch($dataType){
            case true:
              $json = json_decode($response->getBody()->getContents(),true);
              break;
            case false:
              $json = $response->getBody()->getContents();
              break;
            case 'object':
              $json = json_decode($response->getBody()->getContents());
              break;
          }
          break;
        }else{
          $json = null;
        }
      }catch(ClientException  $e){
        if ($e->getResponse()->getStatusCode() > 400) {
          $json = [
            'error' => [
              'code' => $e->getResponse()->getStatusCode(),
              'msg' => $e->getResponse()->getReasonPhrase()
            ]
          ];
        }else{
          switch($dataType){
            case true:
              $json = json_decode((string)$e->getResponse()->getBody(), true);
              break;
            case false:
              $json = $e->getResponse()->getBody();
              break;
            case 'object':
              $json = json_decode($e->getResponse()->getBody());
              break;
          }
          break;
        }
      }catch (RequestException $e) {
        $json = [
          'error' => [
            'code' => 999,
            'msg' => $e->getMessage()
          ]
        ];
      }
    }
    if(is_null($json)){
      \View::make('errors.404');
    }else{
      return $json;
    }
  }

  public static function mesLetra($mes){
    switch($mes){
      case 1:   return 'Enero';
        break;
      case 2:   return 'Febrero';
        break;
      case 3:   return 'Marzo';
        break;
      case 4:   return 'Abril';
        break;
      case 5:   return 'Mayo';
        break;
      case 6:   return 'Junio';
        break;
      case 7:   return 'Julio';
        break;
      case 8:   return 'Agosto';
        break;
      case 9:   return 'Septiembre';
        break;
      case 10:  return 'Octubre';
        break;
      case 11:  return 'Noviembre';
        break;
      case 12:  return 'Diciembre';
        break;
    }
  }

  public static function convertidorFecha($isoDate,$type){
    switch($type){
      case 'completa':
        $mes = SELF::mesLetra(date('m',strtotime($isoDate)));
        $dia = date('j',strtotime($isoDate));
        $ann = date('Y',strtotime($isoDate));
        $date = 'Ciudad de México, a '.$dia.' de '.$mes.' del '.$ann;
      break;
      case 'unix':
        $unix = date('Y-m-d H:i:s', $isoDate/1000);
        $mes = date('m',strtotime($unix));
        $dia = date('j',strtotime($unix));
        $ann = date('Y',strtotime($unix));
        $date = $dia. '-' .$mes. '-' .$ann;      
      break;
    }
    return $date;
  }

  public static function calculaVencimientos(){
    $fecha = new \DateTime(date('Y-m-d'));
    $break = false;
    $incremento = 0;
    $dia['No requiere respuesta'] = '';

    while(!$break){
      $fecha->add(new \DateInterval('P1D'));

      if($fecha->format('w') != 6 && $fecha->format('w') != 0){
        $incremento++;
        switch($incremento){
          case 1:
            $dia['Extra-urgente'] = $fecha->format('d/m/Y');
            break;

          case 3:
            $dia['Urgente'] = $fecha->format('d/m/Y');
            break;

          case 5:
            $dia['Ordinaria'] = $fecha->format('d/m/Y');
            $break = true;
            break;
        }
      } 

    }
    return $dia;
  }

  
}

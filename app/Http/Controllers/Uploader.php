<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use GuzzleHttp\Exception\RequestException;

class Uploader extends Controller
{
	private $util;
  private $keyUpload = '31926f882292';
  private $urlApiUpload = 'https://www.uploadserverdev.cdmx.gob.mx/api/upload';

  function __construct(){
    $this->util = new Utilidades();
  }

	public function enviarCompleto($parametros){
		try{
			$client = new \GuzzleHttp\Client();
			$url    = $this->urlApiUpload;
			$type   = 'POST';
      $parametros = [
				'multipart' => [
					[
						'name' => '_token',
						'contents' => csrf_token(),
					],
          [
              'name'     => 'session',
              'contents' => \Session::get('sessionId'),
          ],
          [
              'name'     => 'token',
              'contents' => $this->keyUpload,
          ],
          [
              'name'     => 'file',
              'contents' => $parametros['file'],
              'filename' => $parametros['name']
          ]
        ]
			];
			$response = $client->request($type,$url, $parametros);
			return json_decode($response->getBody()->getContents(),true);
		}catch(\GuzzleHttp\Exception\ClientException $e){
			return json_encode( $e->getResponse()->getBody());
		}
	}

	public function confirmarArchivo($ruta){
		try{
			$client = new \GuzzleHttp\Client();
			$url    = 'https://www.uploadserverdev.cdmx.gob.mx/api/confirmarArchivo';
			$type   = 'POST';
      $parametros = [
				'multipart' => [
					[
          'name' => '_token',
          'contents' => csrf_token(),
					],
          [
            'name'     => 'session',
            'contents' => \Session::get('sessionId'),
          ],
          [
            'name'     => 'token',
            'contents' => $this->keyUpload,
          ],
          [
            'name'     => 'ruta',
            'contents' => $ruta,
          ]
        ]
			];
			$response = $client->request($type,$url, $parametros);
			return json_decode($response->getBody()->getContents(),true);
		}catch(\GuzzleHttp\Exception\ClientException $e){
			return json_encode( $e->getResponse()->getBody());
		}
	}

	public function revocarArchivo($ruta){
		try{
			$client = new \GuzzleHttp\Client();
			$url    = 'https://www.uploadserverdev.cdmx.gob.mx/api/revocarArchivo';
			$type   = 'POST';
			
			$response = $client->request($type,$url, [
				'multipart' => [
					[
						'name' => '_token',
						'contents' => csrf_token(),
					],
			        [
			            'name'     => 'session',
			            'contents' => \Session::get('sessionId'),
			        ],
			        [
			            'name'     => 'token',
			            'contents' => env('UPLOAD_TOKEN'),
			        ],
			        [
			            'name'     => 'ruta',
			            'contents' => $ruta,
			        ]
			    ]
			]);

			return json_decode($response->getBody()->getContents(),true);
		}catch(\GuzzleHttp\Exception\ClientException $e){

			return json_encode( $e->getResponse()->getBody());
		}
		
	}

	public function obtieneArchivo($ruta){
		set_time_limit(0);
		ini_set("memory_limit","-1");
		try{
			$client = new \GuzzleHttp\Client();
			$url    = 'https://www.uploadserverdev.cdmx.gob.mx/api/entregaArchivo';
			$type   = 'POST';
			
			$response = $client->request($type,$url, [
				'stream'    => true,
				'multipart' => [
					[
						'name' => '_token',
						'contents' => csrf_token(),
					],
			        [
			            'name'     => 'session',
			            'contents' => \Session::get('sessionId'),
			        ],
			        [
			            'name'     => 'token',
			            'contents' => env('UPLOAD_TOKEN'),
			        ],
			        [
			            'name'     => 'ruta',
			            'contents' => $ruta,
			        ]
			    ]
			]);
			$body = $response->getBody();
			
			$file = '';
			while (!$body->eof()) {
				$file .= $body->read(1024);
			    
			}
			
			return json_decode($file,true);
		}catch(\GuzzleHttp\Exception\ClientException $e){

			return json_encode( $e->getResponse()->getBody());
		}
	}

}

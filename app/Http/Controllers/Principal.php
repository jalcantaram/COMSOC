<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use PDF;

class Principal extends Controller{

  public function eliminaSesion(){
  	$parametros = [ 'security'=>['sessionId'=>\Session::get('sessionId')] ];
	  $util = new Utilidades();
	  $retorno = $util->muleConnection('POST','/plataformacore/closeSession',10000,$parametros);	
    \Session::flush();
    return redirect('/');
  }

  public function svte(Request $request){
  	$util = new Utilidades();
		$fsvte = new \App\Http\Controllers\fsvte();
    $request->session()->regenerateToken();
		return \View::make('fsvte.svte')->with(['fichas'=>$fsvte->obtieneFichas()]);	
	}

  public function svteRechOperativo(Request $request){
    \Session::reflash();
    \Session::forget('_id');
    \Session::forget('created');
    \Session::forget('fase');
    \Session::forget('faseStatus');
    \Session::forget('faseActual');
    \Session::forget('faseActualDatos');
    $util = new Utilidades();
    $fsvte = new \App\Http\Controllers\fsvte();
    $request->session()->regenerateToken();
    return \View::make('solicitudes.rechazadas.rechazadas')->with(array('fichas'=>$fsvte->obtieneFichasRechazadas(), 'fichasAut'=>count($fsvte->obtieneFichasAutorizadas()))); 
  }

  public function svteAutOperativo(Request $request){
    \Session::reflash();
    \Session::forget('_id');
    \Session::forget('created');
    \Session::forget('fase');
    \Session::forget('faseStatus');
    \Session::forget('faseActual');
    \Session::forget('faseActualDatos');
    $util = new Utilidades();
    $fsvte = new \App\Http\Controllers\fsvte();
    $request->session()->regenerateToken();
    return \View::make('solicitudes.autorizadas.autorizadas')->with(array('fichas'=>$fsvte->obtieneFichasAutorizadas(), 'fichasRech'=>count($fsvte->obtieneFichasRechazadas()))); 
  }

  public function svteRechTitular(Request $request){
    \Session::reflash();
    \Session::forget('_id');
    \Session::forget('created');
    \Session::forget('fase');
    \Session::forget('faseStatus');
    \Session::forget('faseActual');
    \Session::forget('faseActualDatos');
    $util = new Utilidades();
    $fsvte = new \App\Http\Controllers\fsvte();
    $request->session()->regenerateToken();
    return \View::make('solicitudes.rechazadas.rechazadoTitular')->with(array('fichas'=>$fsvte->obtieneFichasRechazadas(), 'fichasAut'=>count($fsvte->obtieneFichasAutorizadas()))); 
  }

  public function svteAutTitular(Request $request){
    \Session::reflash();
    \Session::forget('_id');
    \Session::forget('created');
    \Session::forget('fase');
    \Session::forget('faseStatus');
    \Session::forget('faseActual');
    \Session::forget('faseActualDatos');
    $util = new Utilidades();
    $fsvte = new \App\Http\Controllers\fsvte();
    $request->session()->regenerateToken();
    return \View::make('solicitudes.autorizadas.autorizadoTitular')->with(array('fichas'=>$fsvte->obtieneFichasAutorizadas(), 'fichasRech' => count($fsvte->obtieneFichasRechazadas()))); 
  }

  public function svteRechDga(Request $request){
    \Session::reflash();
    \Session::forget('_id');
    \Session::forget('created');
    \Session::forget('fase');
    \Session::forget('faseStatus');
    \Session::forget('faseActual');
    \Session::forget('faseActualDatos');
    $util = new Utilidades();
    $fsvte = new \App\Http\Controllers\fsvte();
    $request->session()->regenerateToken();
    return \View::make('solicitudes.rechazadas.rechazadoDga')->with(array('fichas'=>$fsvte->obtieneFichasRechazadas(), 'fichasAut'=>count($fsvte->obtieneFichasAutorizadas()))); 
  }

  public function svteAutDga(Request $request){
    \Session::reflash();
    \Session::forget('_id');
    \Session::forget('created');
    \Session::forget('fase');
    \Session::forget('faseStatus');
    \Session::forget('faseActual');
    \Session::forget('faseActualDatos');
    $util = new Utilidades();
    $fsvte = new \App\Http\Controllers\fsvte();
    $request->session()->regenerateToken();
    return \View::make('solicitudes.autorizadas.autorizadoDga')->with(array('fichas'=>$fsvte->obtieneFichasAutorizadas(), 'fichasRech'=>count($fsvte->obtieneFichasRechazadas()))); 
  }

	public function svteid($id,$item=null){
    \Session::reflash();
		$fsvte = new fsvte();
		if(!$fsvte->existeFase($id)){
			return \View::make('errors.404');
		}else{
			if($id=='firmaelectronica'){
				$vacio=collect(\Session::get('fase'))->filter(function ($i,$k){
					return $k!='citizenId' && $k!='status' && $i['vacio'];	
				})->count();
				if($vacio!=0){
					Session::put('faseActual',$id);		
					$parametros = $fsvte->generaFases() + $fsvte->generaDefinicionv2(); 
					return \View::make('fsvte.fichaSVTE')->with($parametros);
				}
 			}
			\Session::put('faseActual',$id);
			$parametros = $fsvte->generaFases() + $fsvte->generaDefinicion();
			if($parametros['sidebar'][$id]['array']){
				if(!\Session::has('faseStatus.'.$id)){
					\Session::put('faseStatus.'.$id,'table');
				}
			}
			if(is_null($item)){
				\Session::put('faseActualDatos','fase.'.\Session::get('faseActual'));	
			}else{
				\Session::put('faseActualDatos','fase.'.\Session::get('faseActual').'.comisionados.'.$item);
			}		
			return \View::make('fsvte.fichaSVTE')->with($parametros);
		}	
	}

	public function proceso(){
		unset($_POST['_token']);
		$fase = $_POST['fase']; 
		unset($_POST['fase']);
		echo json_encode(array($fase=>$_POST)); exit();	
	}

	public function generaPDF(){
		\Session::reflash();
		$definiciones = \App\StaticContent::obtieneDefinicionFases();
		return PDF::loadHTML(\View::make('info_general')->with(compact('definiciones')))->stream();
	}

	public function envioArchivos(Request $request){
		$archivo = date('dmYHis').'.pdf';
		$request->file('anexo')->move(storage_path('viatinet/tmp'),$archivo);
    dd($request->all());
		return [
      'nombreDocumento' => $request->file('anexo')->getClientOriginalName(),
  		'nombreArchivo'=>$archivo,
  		'id'=>md5(date('dmYHis'))
	   ];
	}

	public function obtienePdf($id){
    // dd('/'.\Session::get('fase.detalleComision.nombre').'/'.\Session::get('_id').'/'.$id);
		if(\Storage::disk('docViatinet')->exists('/'.\Session::get('fase.detalleComision.nombre').'/'.\Session::get('_id').'/'.$id)){
			return \Response::make(\Storage::disk('docViatinet')->get('/'.\Session::get('fase.detalleComision.nombre').'/'.\Session::get('_id').'/'.$id),'200',array(
	              'Content-Type'=>'application/pdf'
	          ));
		}else{
			return \View::make('errors.404');
		}
	}
    
  public function cancelarFichaArray(){
    \Session::reflash();
    \Session::forget('faseStatus.'.\Session::get('faseActual'));
		\Session::forget('faseArrayEdit');
		return redirect('/svte/'.\Session::get('faseActual'));
	}

	public function agregaFichaArray(){
		\Session::put('faseStatus.'.\Session::get('faseActual'),'detail');
		return redirect('/svte/'.\Session::get('faseActual'));
	}

	public function editaFichaArray($id){
		\Session::put('faseStatus.'.\Session::get('faseActual'),'detail');
		\Session::put('faseArrayEdit',$id);
    // dd(\Session::get('faseStatus.registroPersonalNacional'));
		return $this->svteid(\Session::get('faseActual'),$id);
	}

  public function deleteFichaArray($id){
    $util = new Utilidades();
    $parametros = [
      'security' => [
        'sessionId'=>\Session::get('sessionId')
      ],
      'data'=>[
        'idViatico'=>\Session::get('_id'),
        'fase'=>\Session::get('faseActual'),
        'position'=>json_decode($id)
      ]
    ];
    $json = $util->muleConnection('DELETE','/viaticos/schemaViaticos',10010,$parametros);
    if ($json['error']['code'] == 0 && $json != null) {
      flash($json['error']['msg']);
      return redirect('/svte');
    }else{
      flash('Intenta nuevamente!!!')->error();
      return redirect(\URL::previous());
    }
  }

}

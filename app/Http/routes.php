<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', function () {
	return redirect('/home/index');
});

Route::get('/logout',function(){return redirect(env('APP_PLATAFORMA').'/logout'); });

// Route::get('/principal','Main@principal')->middleware('auth.plataforma');
Route::get('/principal','Principal@svte')->middleware('auth.plataforma');
Route::get('/crearNueva', function(){return view('crearNueva');});
// Route::get('/autorizadas', 'Principal@svteAutOperativo');
// Route::get('/rechazadas', 'Principal@svteRechOperativo');

// Route::post('/gfsvte','fsvte@guardaFicha');
Route::post('/nfsvte', 'fsvte@creaFicha');
Route::post('/getSecuencia', 'fsvte@getSecuencia');
// Route::post('/ffsvte','fsvte@finRegistro');
// Route::post('/newItem','fsvte@nuevoItem');
// Route::post('/newItemModal','fsvte@nuevoItemModal');
// Route::post('/loadItemModal','fsvte@cargaItemModal');
// Route::post('/sendFile','Principal@envioArchivos');

// Route::get('/efsvte', 'fsvte@editaFicha');
// Route::get('/getDocumentPdf/{id}','Principal@obtienePdf');
Route::get('/svte','Principal@svte');
// Route::get('/info', 'fsvte@getDetail');
// Route::get('/getEstados', 'fsvte@getEstados');
// Route::get('/getMunicipio', 'fsvte@getMunicipio');
// Route::get('/getContinente', 'fsvte@getContinente');
// Route::get('/getPaisInternacional', 'fsvte@getPaisInternacional');
// Route::get('/svte/{id}','Principal@svteid');
// Route::get('/cancelFicha','Principal@cancelarFichaArray');
// Route::get('/addFicha','Principal@agregaFichaArray');
// Route::get('/editFicha/{id}','Principal@editaFichaArray');
// Route::get('/deleteFicha/{id}','Principal@deleteFichaArray');

// Route::post('/setFirma', 'fsvte@setFirma');
// Route::post('/setFirmainsidePage', 'fsvte@setFirmainsidePage');
// Route::post('/forgetFirma', 'fsvte@forgetFirma');
// Route::post('/signDoc','fsvte@firma');
// Route::post('/signDocDga', 'fsvte@autorizaDGA');
// Route::post('/pdfFirmadoDGA', 'fsvte@muestraPDFAutorizado');
// Route::post('/getDetailPDF','fsvte@getDetailPDF');

// Route::get('/exportcsv', 'fsvte@exportcsv');
// Route::get('/exportcsvAut', 'fsvte@exportcsvAut');
// Route::get('/exportcsvRech', 'fsvte@exportcsvRech');


// // Valida y Firma el Titular 
// Route::group(['middleware'=>'auth.detail:Viatinet_Titular|Viatinet_supTitular'],function(){
//   Route::get('/validaTitular', 'fsvte@firmaTitular');
//   Route::post('/svte/firmaelectronica/generaPDF', 'Principal@generaPDF');
//   Route::post('/pdfFirma', 'fsvte@muestraPDFFirma');
//   Route::post('/regObs','fsvte@observacionesTitular');
//   Route::get('/rechazadoTitular','Principal@svteRechTitular');
//   Route::get('/autorizadoTitular','Principal@svteAutTitular');
//   Route::post('/pdfFirmadoTitular', 'fsvte@muestraPDFFirmaTitular');
// });

// // Autoriza y Firma el DGA
// Route::group(['middleware'=>'auth.detail:Viatinet_Dga|Viatinet_supDga'],function(){
//   Route::get('/validaDga', 'fsvte@firmaDga');
//   Route::post('/pdfFirmaDga', 'fsvte@muestraPDFFirmaDga');
//   Route::post('/regObsDga','fsvte@observacionesDga');
//   Route::get('/rechazadoDga','Principal@svteRechDga');
//   Route::get('/autorizadoDga','Principal@svteAutDga');
// });

// // Verifica y Firma el Administrador  
// // Route::group(['middleware'=>'auth.detail:Viatinet_Operativo'],function(){
// //  Route::get('/validaTitular', 'fsvte@firmaTitular');
// //  Route::post('/svte/firmaelectronica/generaPDF', 'Principal@generaPDF');

// // });
//   
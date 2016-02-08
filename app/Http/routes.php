<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['web']], function () {
    
    Route::get('hola', function () {
    return "hola";
    }); 
    
    
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();  

    Route::get('/home', 'HomeController@index');
    Route::get('obtener_sesion', 'SesionController@obtener_sesion');
    Route::get('validar', 'SesionController@metodo');
    Route::post('validar', 'SesionController@metodo');

    Route::get('registrar', 'SesionController@registrar');
    Route::post('registrar', 'SesionController@registrar');
    Route::get('enviar_email', 'SesionController@enviar_email');
    Route::get('cambiar', 'SesionController@cambiar');
        
});


<?php

/*Reportes sector*/
Route::get('reportes/sector',[
    'uses' => 'reportesSectorController@index',
    'as' =>'reportes/sector'
]);


Route::get('reportes/sector/generar',[
    'uses' => 'reportesSectorController@generarReporte',
    'as' =>'reportes/sector/generar'
]);

Route::get('reportes/sector/excel/{string}',[
    'uses' => 'reportesSectorController@exportarExcel',
    'as' =>'reportes/sector/excel'
]);

/*Reportes invernadero*/

Route::get('reportes/invernadero',[
    'uses' => 'reportesInvernaderoController@index',
    'as' =>'reportes/invernadero'
]);


Route::get('reportes/invernadero/generar',[
    'uses' => 'reportesInvernaderoController@generarReporte',
    'as' =>'reportes/invernadero/generar'
]);

Route::get('reportes/invernadero/excel/{string}',[
    'uses' => 'reportesInvernaderoController@exportarExcel',
    'as' =>'reportes/invernadero/excel'
]);

/*Reportes invernadero plantula*/

Route::get('reportes/plantula',[
    'uses' => 'reportesPlantulaController@index',
    'as' =>'reportes/plantula'
]);


Route::get('reportes/plantula/generar',[
    'uses' => 'reportesPlantulaController@generarReporte',
    'as' =>'reportes/plantula/generar'
]);

Route::get('reportes/plantula/excel/{string}',[
    'uses' => 'reportesPlantulaController@exportarExcel',
    'as' =>'reportes/plantula/excel'
]);
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['api']], function () {
    Route::get('instituicoes', 'Api\\SimulatorController@listInstitutions');
    Route::get('convenios', 'Api\\SimulatorController@listAgreements');
    Route::post('simular', 'Api\\SimulatorController@simulate');
});

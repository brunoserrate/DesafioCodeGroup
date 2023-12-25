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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('jogador', 'JogadorAPIController');
    Route::resource('posicao_time', 'PosicaoTimeAPIController');

    Route::post('partida/gerar-times', 'PartidaAPIController@gerarTime');

    Route::resource('partida', 'PartidaAPIController');
    Route::resource('time', 'TimeAPIController');
});

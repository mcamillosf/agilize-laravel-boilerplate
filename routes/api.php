<?php

use App\Http\Controllers\Prova\MateriaController;
use App\Http\Controllers\Prova\PerguntaController;
use App\Http\Controllers\Prova\ProvaController;
use App\Http\Controllers\Prova\RespostaController;
use App\Http\Controllers\User\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/students', [UserController::class, 'index']);
Route::get('/student/{id}', [UserController::class, 'show']);
Route::post('/student', [UserController::class, 'store']);
Route::put('/student/{id}', [UserController::class, 'update']);
Route::delete('/student/{id}', [UserController::class, 'destroy']);

Route::get('/provas', [ProvaController::class, 'index']);
Route::get('/prova/{id}', [ProvaController::class, 'show']);
Route::post('/prova', [ProvaController::class, 'store']);
Route::put('/prova/{id}', [ProvaController::class, 'update']);
Route::delete('/prova/{id}', [ProvaController::class, 'destroy']);

Route::get('/materias', [MateriaController::class, 'index']);
Route::get('/materia/{id}', [MateriaController::class, 'show']);
Route::post('/materia', [MateriaController::class, 'store']);
Route::put('/materia/{id}', [MateriaController::class, 'update']);
Route::delete('/materia/{id}', [MateriaController::class, 'destroy']);

Route::get('/perguntas', [PerguntaController::class, 'index']);
Route::get('/pergunta/{id}', [PerguntaController::class, 'show']);
Route::post('/pergunta', [PerguntaController::class, 'store']);
Route::put('/pergunta/{id}', [PerguntaController::class, 'update']);
Route::delete('/pergunta/{id}', [PerguntaController::class, 'destroy']);

//Route::post('pergunta/{id}/respostas', [RespostaController::class, 'store']);
Route::get('respostas', [RespostaController::class, 'index']);
Route::get('resposta/{id}', [RespostaController::class, 'show']);
Route::post('resposta', [RespostaController::class, 'store']);
Route::put('resposta/{id}', [RespostaController::class, 'update']);
Route::delete('resposta/{id}', [RespostaController::class, 'destroy']);



<?php

use App\Http\Controllers\Api\DeputadoController;
use App\Http\Controllers\Api\DespesaController;

Route::get('/deputados', [DeputadoController::class, 'index']);
Route::get('/deputados/{id}', [DeputadoController::class, 'show']);
Route::get('/deputados/{id}/despesas', [DespesaController::class, 'index']);
Route::get('/deputados/{id}/estado', [DeputadoController::class, 'outrosDeputadosDoEstado']);


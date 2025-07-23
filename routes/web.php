<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\DeputadosList;
use App\Livewire\ShowDespesas;

use App\Http\Controllers\DeputadoController;

Route::get('/', DeputadosList::class);
Route::get('/deputados/despesas/{id}', ShowDespesas::class)->name('deputados.despesas');

Route::get('/teste', [DeputadoController::class, 'index']);





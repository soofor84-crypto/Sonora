<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SonoraController;

Route::get('/', [SonoraController::class, 'inicio'])->name('inicio');
Route::get('/buscar', [SonoraController::class, 'buscar'])->name('buscar');
Route::get('/playlist', [SonoraController::class, 'playlist'])->name('playlist');
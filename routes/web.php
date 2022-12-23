<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('predio/listar', [\App\Http\Controllers\PredioController::class, 'index'])->name('predio.index');

Route::get('predio/cadastrar', [\App\Http\Controllers\PredioController::class, 'create'])->name('predio.create');
Route::post('predio/store', [\App\Http\Controllers\PredioController::class, 'store'])->name('predio.store');

Route::get('predio/{predio_id}/editar', [\App\Http\Controllers\PredioController::class, 'edit'])->name('predio.edit');
Route::post('predio/update', [\App\Http\Controllers\PredioController::class, 'update'])->name('predio.update');

Route::get('predio/{predio_id}/delete', [\App\Http\Controllers\PredioController::class, 'delete'])->name('predio.delete');



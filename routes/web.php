<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InputPokemonDataController;
use App\Http\Controllers\TopIndexController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/input/pokemon', [InputPokemonDataController::class,'input']) -> name('input.pokemon');

Route::get('/top',[TopIndexController::class,'index'])->name('top');

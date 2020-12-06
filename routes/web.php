<?php

use App\Http\Controllers\AlagamentoController;
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

Route::get('/', function () {
    return view('home');
});

Route::get('/process', function () {
    return view('home');
});

Route::post('process', [AlagamentoController::class, 'processFile'])->name('process.file');

//Route::post('/process', [AlagamentoController::class, 'processFile'])->name('process.file');

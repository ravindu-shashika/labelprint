<?php

use App\Http\Controllers\ReportController;
use FontLib\Table\Type\name;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\ReportController::class, 'index'])->middleware('auth');
Route::match(['get', 'post'],'/generate_pdf', [App\Http\Controllers\ReportController::class, 'generatePDF'])->name('generate_pdf')->middleware('auth');
Route::post('/mark-labels-as-printed', [ReportController::class, 'markLabelsAsPrinted'])->name('mark-labels-as-printed');

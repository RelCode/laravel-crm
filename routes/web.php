<?php

use App\Http\Controllers\LeadsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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

Route::group(['middleware' => 'auth'], function(){
    //all routes here will be navigable if user is logged in
    Route::get('/', function () {
        return view('home');
    })->name('/');
    Route::get('/leads',[LeadsController::class,'index'])->name('leads');
    Route::get('/leads/create',[LeadsController::class,'create'])->name('leads.create');
    Route::post('/leads/create',[LeadsController::class,'store']);
    Route::get('/leads/action/{id}',[LeadsController::class,'action'])->name('leads.action');
    Route::get('/leads/edit/{id}',[LeadsController::class,'edit'])->name('leads.edit');
    Route::post('/leads/edit/{id}',[LeadsController::class,'update']);
    Route::get('/leads/delete',[LeadsController::class,'destroy'])->name('leads.delete');
    Route::get('/leads/action/{id}',[LeadsController::class,'action'])->name('leads.action');
    Route::post('/leads/action/{id}',[LeadsController::class,'handle']);
});

Route::get('/login',[LoginController::class,'index'])->name('login');
Route::post('/login',[LoginController::class,'signin']);
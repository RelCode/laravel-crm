<?php

use App\Http\Controllers\CustomersController;
use App\Http\Controllers\EmailController;
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
    //================================= LEADS STARTS HERE =================================
    Route::get('/leads',[LeadsController::class,'index'])->name('leads');
    Route::get('/leads/create',[LeadsController::class,'create'])->name('leads.create');
    Route::post('/leads/create',[LeadsController::class,'store']);
    Route::get('/leads/action/{id}',[LeadsController::class,'action'])->name('leads.action');
    Route::get('/leads/edit/{id}',[LeadsController::class,'edit'])->name('leads.edit');
    Route::post('/leads/edit/{id}',[LeadsController::class,'update']);
    Route::get('/leads/delete',[LeadsController::class,'destroy'])->name('leads.delete');
    Route::get('/leads/action/{id}',[LeadsController::class,'action'])->name('leads.action');
    Route::post('/leads/action/{id}',[LeadsController::class,'handle']);
    Route::get('/email/compose/{id]',[EmailController::class,'compose'])->name('email.compose');
    //================================== LEADS END HERE ==================================

    //============================== CUSTOMERS STARTS HERE ===============================
    Route::get('/customers',[CustomersController::class,'index'])->name('customers');
    Route::get('/customers/create',[CustomersController::class,'create'])->name('customers.create');
    Route::get('/provinces',[CustomersController::class,'fetchProvinces'])->name('provinces');
    Route::get('/cities/{id}',[CustomersController::class,'fetchCities'])->name('cities/id');
    Route::post('/customers/create',[CustomersController::class,'store']);
    Route::get('/customers/edit/{id}',[CustomersController::class,'edit'])->name('customers.edit');
    Route::post('/customers/edit/{id}',[CustomersController::class,'update']);
    Route::get('/customers/history/{id}',[CustomersController::class,'history'])->name('customers.history');
    //=============================== CUSTOMERS ENDS HERE ===============================
    Route::get('/logout',function(){
        auth()->logout();
        return back();
    })->name('logout');
});

Route::get('/login',[LoginController::class,'index'])->name('login');
Route::post('/login',[LoginController::class,'signin']);
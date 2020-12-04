<?php

use App\Http\Livewire\Accounts;
use App\Http\Livewire\ContractDetail;
use App\Http\Livewire\CustomerDetail;
use App\Http\Livewire\AccountDetail;
use App\Http\Livewire\Projects;
use App\Http\Livewire\Customers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
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


Route::group(['middleware' =>
    'guest',
], function () {
    Route::get('/customers', Customers::class)->name('customers');
    Route::get('/customer/{id}', CustomerDetail::class)->name('customerDetail');
    Route::get('/accounts', Accounts::class)->name('accounts');
    Route::get('/account/{id}', AccountDetail::class)->name('accountDetail');
    Route::get('/contract/{id}', ContractDetail::class)->name('contractDetail');
    Route::get('/projects', Projects::class)->name('projects');
    Route::get('/download', [CustomerDetail::class , 'downloadPDF'])->name('download');
});


Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('/', [LoginController::class, 'postLogin'])->name('postLogin');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register', [LoginController::class, 'postRegister'])->name('postRegister');


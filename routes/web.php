<?php

use App\Http\Livewire\Accounts;
use App\Http\Livewire\ContractDetail;
use App\Http\Livewire\CustomerDetail;
use App\Http\Livewire\AccountDetail;
use App\Http\Livewire\Customers;
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
    return view('welcome');
});
Route::group(['middleware' => [
    'auth:sanctum',
    'verified',
]], function () {
    Route::get('/customers', Customers::class)->name('customers');
    Route::get('/customer/{id}', CustomerDetail::class)->name('customerDetail');
    Route::get('/accounts', Accounts::class)->name('accounts');
    Route::get('/account/{id}', AccountDetail::class)->name('accountDetail');
    Route::get('/contract/{id}', ContractDetail::class)->name('contractDetail');
});
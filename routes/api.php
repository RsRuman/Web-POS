<?php

use App\Http\Controllers\Api\Admin\ClientController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Client\BusinessOrganizationController;
use App\Http\Controllers\Api\Client\CategoryController;
use App\Http\Controllers\Api\Client\CustomerController;
use App\Http\Controllers\Api\Client\InvestmentController;
use App\Http\Controllers\Api\Client\ManagerController;
use App\Http\Controllers\Api\Client\PermissionController;
use App\Http\Controllers\Api\Client\ProductController;
use App\Http\Controllers\Api\Client\PurchaseController;
use App\Http\Controllers\Api\Client\SellController;
use App\Http\Controllers\Api\Client\SupplierController;
use App\Http\Controllers\Api\Client\UtilityHeadController;
use App\Http\Controllers\Api\Client\WithdrawController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

#Public Route For Registration And Login
//Route::post('/register', [AuthController::class, 'register'])->middleware('api');
Route::post('/login', [AuthController::class, 'login'])->middleware('api');

#Auth Route For Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

#Client Route
Route::group(['middleware' => ['auth:api', 'role:client'], 'prefix' => 'client'], function (){
    #Manages Manager
    Route::resource('managers', ManagerController::class)->except('create', 'edit');
    Route::post('managers/{id}/permissions', [ManagerController::class, 'assign_permissions']);
    Route::put('managers/{id}/permissions/update', [ManagerController::class, 'update_permissions']);
    Route::resource('customers', CustomerController::class)->except('create', 'edit');
    Route::resource('categories', CategoryController::class)->except('create', 'edit');
    Route::resource('suppliers', SupplierController::class)->except('create', 'edit');
    Route::resource('investments', InvestmentController::class)->except('create', 'edit');
    Route::resource('withdraws', WithdrawController::class)->except('create', 'edit');
    Route::resource('utilities', UtilityHeadController::class)->except('create', 'edit');
    Route::resource('products', ProductController::class)->except('create', 'edit');
    Route::put('products/{id}/status', [ProductController::class, 'update_status']);

    Route::get('investors', [BusinessOrganizationController::class, 'investor_list']);
    Route::get('business-organization', [BusinessOrganizationController::class, 'show']);
    Route::put('business-organization/update', [BusinessOrganizationController::class, 'update']);
});

#Manager Route
Route::group(['middleware' => ['auth:api', 'role:manager'], 'prefix' => 'manager'], function (){
    #Category
    Route::resource('categories', CategoryController::class)->except('create', 'edit', 'show');
});

#Purchase Route
Route::group(['middleware' => ['auth:api'], 'prefix' => 'client'], function (){
    Route::resource('purchases', PurchaseController::class)->except('create','edit');
});

#Sell Route
Route::group(['middleware' => ['auth:api'], 'prefix' => 'client'], function (){
    Route::resource('sells', SellController::class)->except('create','edit');
});

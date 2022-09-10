<?php

use App\Http\Controllers\Admin\Client\ClientController;
use App\Http\Controllers\Admin\Measurement\ColorController;
use App\Http\Controllers\Admin\Measurement\SizeController;
use App\Http\Controllers\Admin\Measurement\UnitController;
use App\Http\Controllers\Auth\LoginController;
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

Route::group(['prefix' => '/admin', 'as'=>'admin.'], function (){

    #Admin Login Route
    Route::group(['middleware' => 'guest'], function (){
        Route::get('login', [LoginController::class, 'index'])->name('login.index');
        Route::post('login', [LoginController::class, 'login'])->name('login');
    });

    #Admin Authenticate Route
    Route::group(['middleware' => ['auth:web', 'role:admin']], function (){
        #Logout
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');

        #Dashboard
        Route::get('/', function () { return inertia('Home'); })->name('dashboard');

        #Client
        Route::group(['prefix' => '/client', 'as' => 'client.'], function (){
            Route::get('/', [ClientController::class, 'index'])->name('index');
            Route::get('/create', [ClientController::class, 'create'])->name('create');
            Route::get('/show/{id}', [ClientController::class, 'show'])->name('show');
            Route::post('/store', [ClientController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [ClientController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [ClientController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [ClientController::class, 'destroy'])->name('destroy');
        });

        #Unit
        Route::group(['prefix' => '/unit', 'as' => 'unit.'], function (){
            Route::get('/', [UnitController::class, 'index'])->name('index');
            Route::post('/store', [UnitController::class, 'store'])->name('store');
            Route::put('/update/{id}', [UnitController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [UnitController::class, 'destroy'])->name('destroy');

        });

        #Color
        Route::group(['prefix' => '/color', 'as' => 'color.'], function (){
            Route::get('/', [ColorController::class, 'index'])->name('index');
            Route::post('/store', [ColorController::class, 'store'])->name('store');
            Route::put('/update/{id}', [ColorController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [ColorController::class, 'destroy'])->name('destroy');

        });

        #Size
        Route::group(['prefix' => '/size', 'as' => 'size.'], function (){
            Route::get('/', [SizeController::class, 'index'])->name('index');
            Route::post('/store', [SizeController::class, 'store'])->name('store');
            Route::put('/update/{id}', [SizeController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [SizeController::class, 'destroy'])->name('destroy');

        });
    });
});


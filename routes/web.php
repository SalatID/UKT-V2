<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\NilaiController;

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

Route::get('/event/run/{id}',[GuestController::class,'index']);
Route::post('/process/kelompok',[GuestController::class,'setKelompok'])->name('proc-kelompok');

Route::get('/login',[AuthController::class,'login'])->name('login');
Route::group(['prefix'=>'admin'],function(){
    Route::get('/home',[AdminController::class,'home'])->name('home');

    Route::group(['prefix'=>'peserta'],function(){
        Route::get('/',[PesertaController::class,'index'])->name('peserta');
    });

    Route::group(['prefix'=>'kelompok'],function(){
        Route::get('/',[AdminController::class,'kelompok'])->name('kelompok');
    });

    Route::group(['prefix'=>'nilai'],function(){
        Route::get('/',[NilaiController::class,'index'])->name('nilai');
    });

    Route::group(['prefix'=>'user'],function(){
        Route::get('/',[AdminController::class,'user'])->name('admin-user');
    });

    Route::group(['prefix'=>'event'],function(){
        Route::get('/',[AdminController::class,'event'])->name('admin-event');
    });

    Route::group(['prefix'=>'log'],function(){
        Route::get('/',[AdminController::class,'log'])->name('admin-log');
    });

    Route::group(['prefix'=>'master'],function(){
        Route::group(['prefix'=>'komwil'],function(){
            Route::get('/',[AdminController::class,'komwil'])->name('master-komwil');
            Route::post('/',[AdminController::class,'storeKomwil'])->name('store-komwil');
            Route::get('/json-data/{id}',[AdminController::class,'jsonKomwil'])->name('json-komwil');
            Route::post('/update-komwil',[AdminController::class,'updateKomwil'])->name('update-komwil');
            Route::get('/delete/{id}',[AdminController::class,'deleteKomwil'])->name('delete-komwil');
        });
        Route::group(['prefix'=>'unit'],function(){
            Route::get('/',[AdminController::class,'unit'])->name('master-unit');
            Route::post('/',[AdminController::class,'storeUnit'])->name('store-unit');
            Route::get('/json-data/{id}',[AdminController::class,'jsonUnit'])->name('json-unit');
            Route::post('/update-unit',[AdminController::class,'updateUnit'])->name('update-unit');
            Route::get('/delete/{id}',[AdminController::class,'deleteUnit'])->name('delete-unit');
        });
        Route::group(['prefix'=>'jurus'],function(){
            Route::get('/',[AdminController::class,'jurus'])->name('master-jurus');
        });
        Route::group(['prefix'=>'penilai'],function(){
            Route::get('/',[AdminController::class,'penilai'])->name('master-penilai');
        });
        Route::group(['prefix'=>'ts'],function(){
            Route::get('/',[AdminController::class,'ts'])->name('master-ts');
            Route::post('/',[AdminController::class,'storeTs'])->name('store-ts');
            Route::get('/json-data/{id}',[AdminController::class,'jsonTs'])->name('json-ts');
            Route::post('/update-ts',[AdminController::class,'updateTs'])->name('update-ts');
            Route::get('/delete/{id}',[AdminController::class,'deleteTs'])->name('delete-ts');
        });
    });

    Route::group(['prefix'=>'auth'],function(){
        Route::post('/login',[AuthController::class,'procLogin'])->name('proc-login');
        Route::get('/logout',[AuthController::class,'logout'])->name('logout');
    });
});

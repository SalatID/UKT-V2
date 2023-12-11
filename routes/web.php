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
Route::get('/',function(){
    return redirect(env('HOME_URL'));
});
Route::get('/event/run/{alias}',[GuestController::class,'index'])->name('run-event');
Route::post('/process/kelompok',[GuestController::class,'setKelompok'])->name('proc-kelompok');
Route::get('/event/registration/{alias}',[GuestController::class,'selfRegistration'])->name('self-registration');
Route::get('/registration/peserta/{no_peserta}',[GuestController::class,'peserta'])->name('self-peserta');
Route::group(['middleware'=>'guestSession'],function(){
    Route::post('/process/jurus',[GuestController::class,'setJurus'])->name('proc-jurus');
    Route::get('/process/get-sub-jurus',[GuestController::class,'getSubJurus'])->name('get-sub-jurus');
    Route::get('/jurus',[GuestController::class,'pilihJurus'])->name('jurus');
    Route::get('/penilaian',[GuestController::class,'nilai'])->name('penilaian');
});
Route::get('/login',[AuthController::class,'login'])->name('login');
Route::group(['prefix'=>'auth'],function(){
    Route::post('/login',[AuthController::class,'procLogin'])->name('proc-login');
});
Route::group(['prefix'=>'peserta'],function(){
    Route::post('/',[PesertaController::class,'storePeserta'])->name('store-peserta');
});
Route::group(['prefix'=>'komwil'],function(){
    Route::get('/get-json-unit',[AdminController::class,'getJsonUnit'])->name('get-json-unit');
});

Route::group(['prefix'=>'admin','middleware'=>'isLogin'],function(){
    Route::get('/home',[AdminController::class,'home'])->name('home');

    Route::group(['prefix'=>'peserta'],function(){
        Route::get('/',[PesertaController::class,'index'])->name('peserta');
        Route::get('/json-data/{id}',[PesertaController::class,'jsonPeserta'])->name('json-peserta');
        Route::post('/update-peserta',[PesertaController::class,'updatePeserta'])->name('update-peserta');
        Route::get('/delete/{id}',[PesertaController::class,'deletePeserta'])->name('delete-peserta');
        Route::post('/cetak/kartu',[PesertaController::class,'cetakKartu'])->name('cetak-kartu');
    });

    Route::group(['prefix'=>'kelompok'],function(){
        Route::get('/',[AdminController::class,'kelompok'])->name('kelompok');
        Route::get('/reset-filter',[AdminController::class,'resetFilteredPeserta'])->name('reset-filter');
        Route::get('/filtered-peserta',[AdminController::class,'getFilteredPeserta'])->name('filtered-peserta');
        Route::get('/set-anggota-kelompok/{id}',[AdminController::class,'setAnggotaKelompok'])->name('set-anggota-kelompok');
        Route::get('/delete-tmp-anggota-kelompok/{id}',[AdminController::class,'deleteTmpAnggotaKel'])->name('delete-tmp-anggota-kelompok');
        Route::get('/delete-anggota-kelompok/{id}',[AdminController::class,'deleteAnggotaKel'])->name('delete-anggota-kelompok');
        Route::get('/add-kelompok',[AdminController::class,'addKelompok'])->name('add-kelompok');
        Route::post('/',[AdminController::class,'storeKelompok'])->name('store-kelompok');
        Route::get('/json-data/{id}',[AdminController::class,'jsonKelompok'])->name('json-kelompok');
        Route::post('/update-kelompok',[AdminController::class,'updateKelompok'])->name('update-kelompok');
        Route::get('/delete/{id}',[AdminController::class,'deleteKelompok'])->name('delete-kelompok');
        Route::get('/edit/{id}',[AdminController::class,'editKelompok'])->name('edit-kelompok');
    });

    Route::group(['prefix'=>'nilai'],function(){
        Route::get('/',[NilaiController::class,'index'])->name('nilai');
        Route::get('/summary',[NilaiController::class,'summaryNilai'])->name('summary-nilai');
        Route::get('/sertifikat',[NilaiController::class,'cetakSertifikat'])->name('cetak-sertifikat');
        Route::get('/sertifikat/cetak',[NilaiController::class,'previewSertifikat'])->name('preview-sertifikat');
        Route::get('/calculate',[NilaiController::class,'calculateNilai'])->name('calculate-nilai');
    });

    Route::group(['prefix'=>'user'],function(){
        Route::get('/',[AdminController::class,'user'])->name('admin-user');
        Route::post('/',[AdminController::class,'storeUser'])->name('store-user');
        Route::get('/json-data/{id}',[AdminController::class,'jsonUser'])->name('json-user');
        Route::get('/delete/{id}',[AdminController::class,'deleteUser'])->name('delete-user');
        Route::post('/update-user',[AdminController::class,'updateUser'])->name('update-user');
        Route::post('/update-password',[AdminController::class,'updatePassword'])->name('update-password');
    });

    Route::group(['prefix'=>'event'],function(){
        Route::get('/',[AdminController::class,'event'])->name('admin-event');
        Route::post('/',[AdminController::class,'storeEvent'])->name('store-event');
        Route::get('/json-data/{id}',[AdminController::class,'jsonEvent'])->name('json-event');
        Route::get('/delete/{id}',[AdminController::class,'deleteEvent'])->name('delete-event');
        Route::post('/update-event',[AdminController::class,'updateEvent'])->name('update-event');
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
            Route::post('/',[AdminController::class,'storeJurus'])->name('store-jurus');
            Route::get('/json-data/{id}',[AdminController::class,'jsonJurus'])->name('json-jurus');
            Route::post('/update-jurus',[AdminController::class,'updateJurus'])->name('update-jurus');
            Route::get('/delete/{id}',[AdminController::class,'deleteJurus'])->name('delete-jurus');
        });
        Route::group(['prefix'=>'penilai'],function(){
            Route::get('/',[AdminController::class,'penilai'])->name('master-penilai');
            Route::post('/',[AdminController::class,'storePenilai'])->name('store-penilai');
            Route::get('/json-data/{id}',[AdminController::class,'jsonPenilai'])->name('json-penilai');
            Route::post('/update-penilai',[AdminController::class,'updatePenilai'])->name('update-penilai');
            Route::get('/delete/{id}',[AdminController::class,'deletePenilai'])->name('delete-penilai');
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
        Route::get('/logout',[AuthController::class,'logout'])->name('logout');
    });
});

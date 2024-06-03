<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\accountController;
use App\Http\Controllers\Api\MusicUrlController;
use App\Http\Controllers\Api\TempAccountController;
use App\Http\Controllers\Api\ProxyManagementController;
use App\Models\TempAccount;


Route::middleware('static_token_auth')->group(function() {
    //api de temp_accounts
    // Obtener todas las cuentas temporales
    Route::get('temporal-accounts', [TempAccountController::class, 'index']);

    // Crear una nueva cuenta temporal
    Route::post('temporal-accounts', [TempAccountController::class, 'store']);

    // Obtener una cuenta temporal por su ID
    Route::get('temporal-accounts/{id}', [TempAccountController::class, 'show']);



    //api url
    // Ruta para obtener todas las URLs de música
    Route::get('music-urls', [MusicUrlController::class, 'index']);

    //Obtiene la url por el tipo de sitio

    Route::get('music-urls/{type_music}', [MusicUrlController::class, 'indexType'] );

    // Ruta para crear una nueva URL de música
    Route::post('music-urls', [MusicUrlController::class, 'store']);

    // Ruta para actualizar una URL de música por su ID
    Route::put('music-urls/{id}', [MusicUrlController::class, 'update']);



    //api de account bank
    Route::get('account-bank', [accountController::class, 'index']);

    Route::get('account-bank/{id}', [accountController::class, 'show']);

    Route::post('account-bank', [accountController::class, 'store']);

    Route::put('account-bank/{id}', [accountController::class, 'update']);

    Route::delete('account-bank/{id}', [accountController::class, 'destroy']);
});

Route::get('connectSsh', [ProxyManagementController::class, 'index']);

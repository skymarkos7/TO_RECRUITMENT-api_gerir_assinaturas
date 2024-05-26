<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssinaturaController;
use App\Http\Controllers\FaturaController;
use Illuminate\Foundation\Auth\User;

/**
 * User group
 */
Route::get('/user/getall', [UserController::class, 'getAllUsers']);

Route::get('/user/get/{id?}', [UserController::class, 'getUser']);

Route::post('/user/insert', [UserController::class, 'insertUser']);

Route::put('/user/update/{id?}', [UserController::class, 'updateUser']);

Route::delete('/user/delete/{id?}', [UserController::class, 'deleteUser']);

/**
 * Assinatura group
 */
Route::get('/assinatura/getall', [AssinaturaController::class, 'getAllAssinaturas']);

Route::get('/assinatura/get/{id?}', [AssinaturaController::class, 'getAssinatura']);

Route::post('/assinatura/insert', [AssinaturaController::class, 'insertAssinaturas']);

Route::put('/assinatura/update/{id?}', [AssinaturaController::class, 'updateAssinatura']);

Route::delete('/assinatura/delete/{id?}', [AssinaturaController::class, 'deleteAssinatura']);

/**
 * Fatura group
 */
Route::get('/fatura/getall', [FaturaController::class, 'getAllFaturas']);

Route::get('/fatura/get/{id?}', [FaturaController::class, 'getFatura']);

Route::post('/fatura/insert', [FaturaController::class, 'insertFatura']);

Route::put('/fatura/update/{id?}', [FaturaController::class, 'updateFatura']);

Route::delete('/fatura/delete/{id?}', [FaturaController::class, 'deleteFatura']);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SignatureController;
use App\Http\Controllers\InvoiceController;
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
 * Signature group
 */
Route::get('/signature/getall', [SignatureController::class, 'getAllSignatures']);

Route::get('/signature/get/{id?}', [SignatureController::class, 'getSignature']);

Route::post('/signature/insert', [SignatureController::class, 'insertSignatures']);

Route::put('/signature/update/{id?}', [SignatureController::class, 'updateSignature']);

Route::delete('/signature/delete/{id?}', [SignatureController::class, 'deleteSignature']);

/**
 * Invoice group
 */
Route::get('/invoice/getall', [InvoiceController::class, 'getAllInvoices']);

Route::get('/invoice/get/{id?}', [InvoiceController::class, 'getInvoice']);

Route::post('/invoice/insert', [InvoiceController::class, 'insertInvoice']);

Route::put('/invoice/update/{id?}', [InvoiceController::class, 'updateInvoice']);

Route::delete('/invoice/delete/{id?}', [InvoiceController::class, 'deleteInvoice']);

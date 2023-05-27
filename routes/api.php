<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Public;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::post('auth/register', App\Http\Controllers\Auth\RegisterController::class);
Route::post('auth/login', App\Http\Controllers\Auth\LoginController::class);


 
Route::middleware('auth:sanctum')->group(function() {
    
    Route::prefix('owner')->group(function () {
        Route::get('properties',[\App\Http\Controllers\Owner\PropertyController::class, 'index']);
        Route::post('properties',[\App\Http\Controllers\Owner\PropertyController::class, 'store']);
    });

    Route::prefix('user')->group(function () {
        Route::get('bookings',[\App\Http\Controllers\User\BookingController::class, 'index']);
    });
});

Route::get('search',Public\PropertySearchController::class);
Route::get('properties/{property}',Public\PropertyController::class);
Route::get('apartments/{apartment}',Public\ApartmentController::class);
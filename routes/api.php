<?php

use App\Http\Controllers\EncodeController;
use App\Http\Controllers\RainbowController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('/v1')->group(function () {

    // GET api/v1/rotors
    Route::get('/rotors', function () {
        return config('enigma.rotors');
    });

    // GET api/v1/encode
    Route::get('/encode', EncodeController::class);

    // GET api/v1/lookup
    Route::get('/lookup', RainbowController::class);
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
//use App\Http\Controllers\AccomodationsController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/usuarios', [TestController::class, 'getData']);
// Route::get('/bookings', [TestController::class, 'testBookingsQuery']);
//existen diferencias entre las rutas de tipo web y las de tipo api

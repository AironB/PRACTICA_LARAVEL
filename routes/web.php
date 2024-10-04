<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/usuarios', [TestController::class, 'getUsers']);
Route::get('/bookings', [TestController::class, 'testBookingsQuery']);
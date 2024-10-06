<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AccomodationsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Route::get('bookings',[TestController::class, 'testBookingsQuery']);
//Ruta de alojamientos
//nos mostrara todos los alojamientos
Route::get('/V1/accomodations', [AccomodationsController::class, 'getAccomodations']);
//Nos mostrara los alojamientos por el id
//esta ruta lleva parametro
Route::get('/V1/accomodation_by_id/{id}', [AccomodationsController::class,
'get_accomodation_by_id']);
//Guardando un alojamiento
Route::post('/V1/accomodation', [AccomodationsController::class, 'store']);
//Actualizando un alojamiento
Route::put('/V1/accomodation/{id}', [AccomodationsController::class, 'update']);

//Rutas de reservaciones
Route::patch('/V1/status_booking/{id}', [BookingController::class, 'update_status']);
//Guardando un booking
Route::post('/V1/booking',[BookingController::class, 'store']);
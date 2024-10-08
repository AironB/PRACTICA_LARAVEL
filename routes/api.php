<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AccomodationsController;
use App\Http\Middleware\bookingsApiToken;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
//Rutas protegidas por medio de Sanctum(agrupar)
Route::middleware('auth:sanctum')->group(function(){
    Route::get('/V1/bookings', [BookingController::class, 'get_bookings']);
    //el signo ? indica que el parametro es opcional
    Route::get('/V1/bookings_by_year/{year?}', [BookingController::class, 'get_bookings_by_year']);

    Route::get('/V1/bookings/calendar/{id_accomodation}', [BookingController::class, 'calendar_accomodation_bookings']);
});

//Route::get('bookings',[TestController::class, 'testBookingsQuery']);

//Guardando un alojamiento
Route::post('/V1/accomodation', [AccomodationsController::class, 'store']);
//Actualizando un alojamiento
Route::put('/V1/accomodation/{id}', [AccomodationsController::class, 'update']);

//Rutas de reservaciones
Route::patch('/V1/status_booking/{id}', [BookingController::class, 'update_status']);
//Guardando un booking
Route::post('/V1/booking',[BookingController::class, 'store']);


//ruta con autorizacion basica
Route::get('/V1/bookings_by_user', [BookingController::class, 'get_bookings_by_user']);

//Ruta para el login
Route::post('/V1/login', [LoginController::class, 'login']);
//Crear un middleware personalizado para proteger rutas(API-key)

Route::middleware(bookingsApiToken::class)->group(function() {
//Ruta de alojamientos
//nos mostrara todos los alojamientos
Route::get('/V1/accomodations', [AccomodationsController::class, 'getAccomodations']);
//Nos mostrara los alojamientos por el id
//esta ruta lleva parametro
Route::get('/V1/accomodation_by_id/{id}', [AccomodationsController::class,
'get_accomodation_by_id']);
});

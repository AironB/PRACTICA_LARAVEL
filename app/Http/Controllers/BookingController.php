<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Bookings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Mime\Encoder\Base64Encoder;

class BookingController extends Controller
{
    //metodo para actualizar el estado de la reservacion
    public function update_status(Request $request, $id){
        //validando la entrada de datos
        $validator = Validator::make($request->all(),[
            'status' => 'required|string'
        ]);
        
        if($validator->fails()){
            return response()->json([
                'message'=>'Validation Error',
                'errors' => $validator->errors()
            ]);
        }
        //actualizar el estado
        $booking = Bookings::find($id);
        $booking->status = $request->input('status');
        $booking->update();
        
        return response()->json(['message'=>'status succesfully updated']);
    }
    //Metodo para guardar una reservacion
    public function store(Request $request){
        //validacion de datos
        $validator = Validator::make($request->all(),[
            'booking'=>'required|string|max:10',
            'check_in_date'=>'required|date_format:Y-m-d',
            //validamos que la fecha de salida sea despues de la fecha de entrada
            'check_out_date'=>'required|date_format:Y-m-d|after:check_in_date',
            'total_amount'=>'required|numeric',
            'accomodation_id'=>'required|exists:accomodations,id',
            'user_id'=>'required|numeric|exists:users,id'
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'Validation Error',
                'errors'=>$validator->errors(),
            ]);
        }
        //guardar el booking
        //insert into bookings
        $booking = new Bookings();
        $booking->booking=$request->input('booking');
        $booking->check_in_date = $request->input('check_in_date');
        $booking->check_out_date = $request->input('check_out_date');
        $booking->total_amount=$request->input('total_amount');
        $booking->status="CONFIRMED";
        $booking->accomodation_id=$request->input('accomodation_id');
        $booking->user_id=$request->input('user_id');
        $booking->save();
        return response()->json(['message'=>'Successfully registered'], 201);
    }
    //metodo para obtener todas las reservaciones
    public function get_bookings(){
        //$booking = Bookings::get();
        /**select bookings.*, users.name as user, accomodations.name as accomodation from bookings inner join users on bookings.user_id =users.id inner join accomodations on bookings.accomodations_id=accomodations.id */
        //$bookings = Bookings::all();bookings.user_id
        $bookings = Bookings::join('users', 'bookings.user_id', 'users.id')->join('accomodations','bookings.accomodation_id', 'accomodations.id')->select('bookings.*', 'users.name as user', 'accomodations.name as accomodation')->get();
        
        if(count($bookings)>0){
            return response()->json($bookings, 200);
        }
        //return response('Message'=>'Accomodations not found', 404);
    }

    //metodo para filtrar reservaciones por año
    public function get_bookings_by_year($year=null){
        //validando el parametro
        if(!$year){
            //extraemos el anio de la fecha actual
            $year = Carbon::now()->year;
        }
        //consulta sql
        //select * from bookings where extract(YEAR from check_out_date) = 2024; (whereYear)
        $bookings = Bookings::with([
            /**mostramos con el with el objeto del usuario y el alojamiento eso hace referencia al metodo belongsTo del modelo booking */
            'user:id,name,email,phone_number', 
            'accomodation:id,address,description,image'])->whereYear('check_out_date', $year)->get();
        if(count($bookings)>0){
            return response()->json($bookings, 200);
        }
        return response()->json([],400);
    }
    //metodo para mostrar reservaciones con un rango de fechas por alojamiento
    public function calendar_accomodation_bookings(Request $request, $id_accomodation){
        //validando las fechas
        $validator = Validator::make($request->all(),[
            'start_date'=>'nullable|date_format:Y-m-d',
            'end_date'=>'nullable|date_format:Y-m-d|after:start_date'
        ]);
        if($validator->fails()){
            return response()->json([
                'errors'=>$validator->errors()
            ], 400);
        }
        /**
         * select * from bookings where accomodation_id =11 and check_out_date between "2024-09-01" and "2024-11-30"
         */
        $query = Bookings::where('accomodation_id', $id_accomodation);
        //validamos si la persona ingreso las fechas
        if ($request->has('start_date')&&$request->has('end_date')){
            //si la persona ingreso las fechas, agregamos en la consulta SQL el rango de fechas
            $start_date = Carbon::parse($request->input('start_date'));//2024-12-30
            
            $end_date = Carbon::parse($request->input('end_date'));//2024-12-31
            
            $test_date=$start_date->diffInMonths($end_date);
            
            if($test_date>3){
                return response()->json(['error'=>'the range cannot exceed 3 months'],422);
            }
            echo "\nPrueba: $test_date";
            //DiffInMonths

            $query->whereBetween('check_out_date', [$start_date, $end_date]);
        }
        $bookings = $query->get();
        if(count($bookings)>0)
        if($bookings->count()>0)
        {
            return response()->json($bookings, 200);
        }
            return response()->json(['message'=>'No bookings at this time'], 400);
        //return response()->json($bookings, 200);
    }
    //Autorizacion baseca, metodo para ver las reservaciones por usuario
    public function get_bookings_by_user(Request $request){
        $token = $request->header('Authorization');
        //comparar el token de autorizacion con los token de los usuarios
        $users=User::all();
        foreach($users as $user){
            //cada usuario va a tener un token
            $credentials = base64_encode($user['email'].":".$user['password']);
            $tokenExpected="Basic ".$credentials;
            // echo $user['name']."<br>";
            // echo $tokenExpected."<br>";
            if($token==$tokenExpected){
                //ver todas las reservaciones por usuario
                //select * from bookings where user_id=?
                $bookings = Bookings::where('user_id', $user['id'])->get();
                if($bookings->count()>0)
                {
                   return response()->json($bookings, 200);
                }
                return response()->json(['message'=>'No bookings', 400]);

            }
        }
        //No esta autorizada
        return response()->json(['message'=>'No existe en la base de datos']);
       // echo $token;
    }
}

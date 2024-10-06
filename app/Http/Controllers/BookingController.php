<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

}

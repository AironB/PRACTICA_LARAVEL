<?php

namespace App\Http\Controllers;
use App\models\User;

use App\Models\Bookings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    function getData(){
       //select * from users
        $users = User::all(); //[]
        return response()->json($users);
       
    }
    public function testBookingsQuery(){
        //select * from bookings
        //query builder
        //$booking = DB::table('bookings')->get();
         //la misma consulta pero con ORM
       //metodos mapeados o consultas mapeadas
       //$booking = Bookings::all();
        //hacemos un select a dos columnas de la tabla
        //$booking=DB::table('bookings')->select('booking','total_amount')->get();
        
        //hacemos la consulta con el where al id 4
       // $booking = DB::table('bookings')->select('*')->where('id', '=', 4)->get();
      //hacemos la consulta con orm
        //$booking = Bookings::find(4);//el metodo find solo busca el id
        //aca combinamos una query builder con ORM
        //$booking = Bookings::where('total_amount', '>=','100')->get();
        //select * from bookings order by user_id des
        $booking = Bookings::orderBy('user_id', 'desc')->get();
        //Seleccionamos solo el primer registro con la coincidencia de name Jhon
        //DB::table('users')->where('name', 'Jhon')->first();
        //return json_encode($booking);
        return response()->json($booking, 200);
    }

}

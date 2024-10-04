<?php

namespace App\Http\Controllers;
use App\models\User;

use illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class TestController extends Controller
{
    function getData(){
       //select * from users
        $users = User::all(); //[]
        return response()->json($users);
       
    }
    public function testBookingsQuery(){
        //select * from bookings
        $booking = DB::table('bookings')->get();
        return json_encode($booking);
        return response()->json($booking, 200);
    }
}

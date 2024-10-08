<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers;

class LoginController extends Controller
{
   public function login(Request $request){
    $email = $request->input('email');
    $password = $request->input('password');
    //validamos que el correo y el password existan en la base de datos
    //select * from users where email = $emailand password ...
    $user = User::where('email', $email)->where('password','=', $password)->first();//{}
    //return response()->json($user);
    //si el objeto existe
    if($user){
        $token = $user->createToken('api-token')->plainTextToken;
        //echo $token;
        return response()->json([
            "user"=>$email,
            "token"=>$token
        ], 200);
        }
        return response()->json(["message"=> "You are not Authorized"], 401);
}
}
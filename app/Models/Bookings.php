<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bookings extends Model
{
    use HasFactory;
    protected $table ="bookings";
    //definiendo la relacion de las tablas bookings y accomodation
    public function user(){
        //relacionamos al modelo user y la foranea de la tabla bookings
        return $this->belongsTo(User::class, 'user_id');
    }
    public function accomodation(){
        return $this->belongsTo(Accomodations::class, 'accomodation_id');
    }
}

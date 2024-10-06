<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accomodations;
use Illuminate\Support\Facades\Validator;

class AccomodationsController extends Controller
{
    //metodo para obtener todos los alojamientos
    public function getAccomodations(){
        //mostrar todos los alojamientos
        $accomodations = Accomodations::all();//[]
        if(count($accomodations)>0){
            return response()->json($accomodations, 200);
        }
        else
        //Si la tabla no tiene datos nos envia un mensaje
        {
            return response()->json(['message'=>'No accomodations at the moment'], 400);
        }
    }
    public function get_accomodation_by_id($id){
        //select * from accomodations where id= ?
        $accomodation = Accomodations::find($id);//{}/null
        if($accomodation != null){
            //enviamos un mensaje si encuentra el alojamiento
            return response()->json(['message' => $accomodation], 200);
        }
        //enviamos un mensaje en caso de no encontrar el alojamiento
        return response()->json(['message' => 'Accomomdation not found'], 400);
    }
    public function store(Request $request){
        //Guardando un alojamiento (insert into...)
        //validar entrada de datos
        $validator = Validator::make($request->all(), [
            //reglas para cada entrada de datos
            'name'=>'required|string|max:70',
            'address'=>'required|string|max:100',
            'description'=>'required|string',
            'image'=>'required|string'
        ]);
        //en base a las reglas de validacion, verificar si se cumple o no se cumple
        if($validator->fails()){
            return response()->json([
                'message'=>'Validation Error',
                'Errors'=> $validator->errors(),
            ], 400);
        }
        //tarea = new tarea();
        //instanciamos la clase de Accomodations
        $accomodation = new Accomodations();
        $accomodation->name = $request->input('name');
        $accomodation->address= $request->input('address');
        $accomodation->description=$request->input('description');
        $accomodation->image=$request->input('image');
        $accomodation->save();

        return response()->json(['message'=>'Successfully registered'],201);
    }
    public function update(Request $request, $id){
        //actualizar(update table set campo = valor... where id = ?)
        //metodo para encontrar un registro por su id
        $accomodation=Accomodations::find($id);//{}
        if($accomodation != null){
        
        //$accomodation = new Accomodations();
        $accomodation->name = $request->input('name');
        $accomodation->address= $request->input('address');
        $accomodation->description=$request->input('description');
        $accomodation->image=$request->input('image');
        $accomodation->update();

        return response()->json(['message'=>'Correctly updated'],200);
        }
        //enviamos un mensaje en caso de no encontrar el alojamiento
        return response()->json(['message' => 'Accomomdation not found'], 400);
    }
}

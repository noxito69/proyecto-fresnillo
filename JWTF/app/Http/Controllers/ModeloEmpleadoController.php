<?php

namespace App\Http\Controllers;

use App\Models\ModeloEmpleado;
use Illuminate\Http\Request;

class ModeloEmpleadoController extends Controller
{
    public function index(){

        $modelos = ModeloEmpleado::all();
        return response()->json($modelos);
        

    }

    public function store(Request $request){

        $request->validate([
            'nombre' => 'required|max:50',
        ]);

        $modelo = ModeloEmpleado::create($request->all());

        return response()->json([
            'message' => 'ModeloEmpleado created successfully',
            'data' => $modelo
        ], 201);

    }
    
    
    public function show($id){

        $modelo = ModeloEmpleado::find($id);

        if($modelo){
            return response()->json($modelo);
        }else{
            return response()->json([
                'message' => 'ModeloEmpleado not found'
            ], 404);
        }

    }

    public function update(Request $request, $id){

        $modelo = ModeloEmpleado::find($id);

        if($modelo){
            $modelo->update($request->all());
            return response()->json([
                'message' => 'ModeloEmpleado updated successfully',
                'data' => $modelo
            ], 200);
        }else{
            return response()->json([
                'message' => 'ModeloEmpleado not found'
            ], 404);
        }

    }

    public function destroy($id){

        $modelo = ModeloEmpleado::find($id);

        if($modelo){
            $modelo->delete();
            return response()->json([
                'message' => 'ModeloEmpleado deleted successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'ModeloEmpleado not found'
            ], 404);
        }

    }
    

}

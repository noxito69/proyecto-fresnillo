<?php

namespace App\Http\Controllers;

use App\Models\ModeloEmpleado;
use Illuminate\Http\Request;

class ModeloEmpleadoController extends Controller
{
    public function index(){

        $modelos = ModeloEmpleado::where('is_active', true)->orderBy('nombre')->get();
        return response()->json($modelos);
        

    }

    public function indexPg(Request $request){

        $query = $request->query();
        $page = (int)$query['page'];
        $perPage = (int)$query['pageSize'];

        $modelos = ModeloEmpleado::orderBy('nombre')->paginate($perPage, ['*'], 'page', $page); 
        return response()->json($modelos);

    }

    public function search(Request $request) {
        $query = $request->input('query');
        $results = ModeloEmpleado::where("nombre", "LIKE", "%$query%")->paginate(20);
        return response()->json($results);
    }

    public function store(Request $request){

        $request->validate([
            'nombre' => 'required|max:50|unique:modelo_empleados',
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

    public function delete($id){

        $modeloEmpleado = ModeloEmpleado::find($id);

        if(!$modeloEmpleado) {
            return response()->json(["error" => "Modelo no encontrado"], 404);
        }

        if($modeloEmpleado->is_active) {
            
            $modeloEmpleado->is_active = false;
            $modeloEmpleado->save();
            return response()->json(['message' => 'Modelo deshabilitado correctamente.']);
        }
        $modeloEmpleado->is_active = true;
        $modeloEmpleado->save();

        return response()->json(['message' => 'Modelo habilitado correctamente.']);


    }
    

}

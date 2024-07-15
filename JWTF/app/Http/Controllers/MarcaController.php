<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function index(Request $request){

        $query = $request->query();

        $page = (int)$query['page'];
        $perPage = (int)$query['pageSize'];

        $marcas = Marca::orderBy('nombre')->paginate($perPage, ['*'], 'page', $page); 
        return response()->json($marcas);
    }

    public function search(Request $request) {
        $query = $request->input('query');
        $results = Marca::where("nombre", "LIKE", "%$query%")->paginate(20);
        return response()->json($results);
    }


    public function getMarcas(){
        $marcas = Marca::where('is_active', true)->orderBy('nombre')->get();
        return response()->json($marcas);
    }

    public function store(Request $request){
        $request->validate([
            'nombre' => 'required|max:255|unique:marcas',
        ]);

        $marca = Marca::create($request->all());

        return response()->json([
            'message' => 'Marca created successfully',
            'data' => $marca], 201);
    }

    public function show($id){
        $marca = Marca::find($id);

        if($marca)
        {
            return response()->json($marca);
        }
        else
        {
            return response()->json([
                'message' => 'Marca not found'
            ], 404);
        }
    }

    public function update(Request $request, $id){
        $marca = Marca::find($id);

        if($marca)
        {
            $marca->update($request->all());
            return response()->json([
                'message' => 'Marca updated successfully',
                'data' => $marca
            ], 200);
        }
        else
        {
            return response()->json([
                'message' => 'Marca not found'
            ], 404);
        }
    }

    public function delete($id){
        

        $marca = Marca::find($id);

        if(!$marca)
        {
            return response()->json([
                'message' => 'Marca not found'
            ], 404);
        }

        if($marca->is_active){

            $marca->is_active = false;
            $marca->save();
            return response()->json([
                'message' => 'Marca deshabilitada'
            ], 200);

        }
        $marca->is_active = true;
        $marca->save();

        return response()->json([
            'message' => 'Marca habilitada'
        ], 200);

    }
}

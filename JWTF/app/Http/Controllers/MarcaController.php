<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function index(){
        $marcas = Marca::all();
        return response()->json($marcas);
    }
    
    public function store(Request $request){
        $request->validate([
            'nombre' => 'required|max:255',
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

    public function destroy($id){
        $marca = Marca::find($id);

        if($marca)
        {
            $marca->delete();
            return response()->json([
                'message' => 'Marca deleted successfully'
            ], 200);
        }
        else
        {
            return response()->json([
                'message' => 'Marca not found'
            ], 404);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;

class ModeloController extends Controller
{
    public function index()
    {
        $modelos = Modelo::all();
        return response()->json($modelos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'marca_id' => 'required|integer',
        ]);

        $modelo = Modelo::create($request->all());

        return response()->json([
            'message' => 'Modelo created successfully',
            'data' => $modelo], 201);
    }

    public function show($id)
    {
        $modelo = Modelo::find($id);

        if($modelo)
        {
            return response()->json($modelo);
        }
        else
        {
            return response()->json([
                'message' => 'Modelo not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $modelo = Modelo::find($id);

        if($modelo)
        {
            $modelo->update($request->all());
            return response()->json([
                'message' => 'Modelo updated successfully',
                'data' => $modelo
            ], 200);
        }
        else
        {
            return response()->json([
                'message' => 'Modelo not found'
            ], 404);
        }
    }

    public function destroy($id)
    {
        $modelo = Modelo::find($id);

        if($modelo)
        {
            $modelo->delete();
            return response()->json([
                'message' => 'Modelo deleted successfully'
            ], 200);
        }
        else
        {
            return response()->json([
                'message' => 'Modelo not found'
            ], 404);
        }
    }

    
}

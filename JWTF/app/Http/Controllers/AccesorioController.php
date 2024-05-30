<?php

namespace App\Http\Controllers;
use App\Models\Accesorio;

use Illuminate\Http\Request;

class AccesorioController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $accesorios = Accesorio::all();
        return response()->json($accesorios);
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $request->validate([
            'cantidad' => 'required|integer',
            'articulo' => 'required|string|max:255',
            'marca' => 'nullable|string|max:255',
            'codigo_barras' => 'required|string|unique:accesorios|max:255',
        ]);

        $accesorio = Accesorio::create($request->all());

        return response()->json($accesorio, 201);
    }

    // Display the specified resource
    
    public function show($id)
    {
        $accesorio = Accesorio::find($id);

        if (!$accesorio) {
            return response()->json(['message' => 'Accesorio no encontrado'], 404);
        }

        return response()->json($accesorio);
    }

    // Update the specified resource in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer',
            'articulo' => 'required|string|max:255',
            'marca' => 'nullable|string|max:255',
            'codigo_barras' => 'required|string|unique:accesorios,codigo_barras,' . $id . '|max:255',
        ]);

        $accesorio = Accesorio::find($id);

        if (!$accesorio) {
            return response()->json(['message' => 'Accesorio no encontrado'], 404);
        }

        $accesorio->update($request->all());

        return response()->json($accesorio);
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {
        $accesorio = Accesorio::find($id);

        if (!$accesorio) {
            return response()->json(['message' => 'Accesorio no encontrado'], 404);
        }

        $accesorio->delete();

        return response()->json(['message' => 'Accesorio eliminado con éxito']);
    }
}

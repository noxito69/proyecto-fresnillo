<?php

namespace App\Http\Controllers;
use App\Models\Accesorio;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class AccesorioController extends Controller
{
    
    public function index()
    {
        $accesorios = Accesorio::all();
        return response()->json($accesorios);
    }

   
    
    public function store(Request $request)
    {
        $messages = [
            'cantidad.required' => 'La cantidad es requerida.',
            'cantidad.integer' => 'La cantidad debe ser un número entero.',
            'cantidad.max' => 'La cantidad no debe exceder los 999.',
            'articulo.required' => 'El artículo es requerido.',
            'articulo.max' => 'El artículo no debe exceder los 255 caracteres.',
            'marca.required' => 'La marca es requerida.',
            'marca.max' => 'La marca no debe exceder los 255 caracteres.',
            'codigo_barras.required' => 'El código de barras es requerido.',
            'codigo_barras.unique' => 'Este código de barras ya existe.',
            'codigo_barras.max' => 'El código de barras no debe exceder los 255 caracteres.',
        ];

        $validated = Validator::make($request->all(), [
            'cantidad' => 'required|integer|max:999',
            'articulo' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'codigo_barras' => 'required|string|unique:accesorios|max:255',
        ], $messages);

        if($validated->fails()){
            return response()->json(['message' => $validated->errors()], 400);
        }
        else{
            $accesorio = Accesorio::create($request->all());
            return response()->json($accesorio, 201);
        }
    }


    
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

<?php

namespace App\Http\Controllers;
use App\Models\Accesorio;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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
            'articulo.min' => 'El artículo debe tener al menos 1 caracter.',
        ];

        $validated = Validator::make($request->all(), [
            'cantidad' => 'required|integer|max:999|min:1',
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

    public function getByBarCode($codigo_barras)
    {
        $accesorio = Accesorio::where('codigo_barras', $codigo_barras)->first();

        if ($accesorio) {
            return response()->json($accesorio, 200);
        } else {
            return response()->json(['message' => 'Accesorio no encontrado'], 404);
        }
    }

    public function updateQuantity(Request $request, $codigo_barras)
    {
        $accesorio = Accesorio::where('codigo_barras', $codigo_barras)->first();

        if (!$accesorio) {
            return response()->json(['message' => 'Accesorio no encontrado'], 404);
        }

        $accesorio->cantidad += $request->cantidad;
        $accesorio->save();

        return response()->json(['message' => 'Cantidad actualizada con éxito']);
    }

    public function updateQuantityMinus(Request $request, $id)
    {
        $accesorio = Accesorio::find($id);

        if ($accesorio) {
            $cantidadRestar = $request->input('cantidad');
            Log::info('Cantidad a restar: ' . $cantidadRestar);

            if ($accesorio->cantidad >= $cantidadRestar) {
                $accesorio->cantidad -= $cantidadRestar;
                $accesorio->save();
                Log::info('Nueva cantidad de accesorio: ' . $accesorio->cantidad);
                return response()->json($accesorio);
            } else {
                return response()->json([
                    'message' => 'Cantidad insuficiente en el inventario'
                ], 400);
            }
        } else {
            return response()->json([
                'message' => 'Accesorio no encontrado'
            ], 404);
        }
    }

    public function getTotal()
    {
        $total = Accesorio::count();

        return response()->json(['total' => $total], 200);
    }

    



}

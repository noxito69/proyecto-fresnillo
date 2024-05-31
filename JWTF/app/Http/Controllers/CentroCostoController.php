<?php

namespace App\Http\Controllers;
use App\Models\CentroCosto;

use Illuminate\Http\Request;

class CentroCostoController extends Controller
{
    public function index()
    {
        $centroCostos = CentroCosto::all();
        return response()->json($centroCostos);
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $messages = [
            'nombre.required' => 'El campo nombre es requerido',
            'nombre.unique' => 'El nombre ya ha sido tomado',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres',
        ];

        $request->validate([
            'nombre' => 'required|unique:centro_costos|max:255',
        ], $messages);

        $centroCosto = CentroCosto::create($request->all());

        return response()->json($centroCosto, 201);
    }

    // Display the specified resource
    public function show($id)
    {
        $centroCosto = CentroCosto::find($id);

        if (!$centroCosto) {
            return response()->json(['message' => 'Centro de costos no encontrado'], 404);
        }

        return response()->json($centroCosto);
    }

    // Update the specified resource in storage
    public function update(Request $request, $id)
    {
        $messages = [
            'nombre.required' => 'El campo nombre es requerido',
            'nombre.unique' => 'El nombre ya ha sido tomado',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres',
        ];

        $request->validate([
            'nombre' => 'required|unique:centro_costos,nombre,' . $id . '|max:255',
        ], $messages);

        $centroCosto = CentroCosto::find($id);

        if (!$centroCosto) {
            return response()->json(['message' => 'Centro de costos no encontrado'], 404);
        }

        $centroCosto->update($request->all());

        return response()->json($centroCosto);
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {
        $centroCosto = CentroCosto::find($id);

        if (!$centroCosto) {
            return response()->json(['message' => 'Centro de costos no encontrado'], 404);
        }

        $centroCosto->delete();

        return response()->json(['message' => 'Borrado exitoso'], 204);
    }
}


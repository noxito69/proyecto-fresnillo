<?php

namespace App\Http\Controllers;
use App\Models\Departamento;

use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $departamentos = Departamento::all();
        return response()->json($departamentos);
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:departamentos|max:255',
            'centro_costos_id' => 'required|exists:centro_costos,id',
        ]);

        $departamento = Departamento::create($request->all());

        return response()->json($departamento, 201);
    }

    // Display the specified resource
    public function show($id)
    {
        $departamento = Departamento::find($id);

        if (!$departamento) {
            return response()->json(['message' => 'Departamento no encontrado'], 404);
        }

        return response()->json($departamento);
    }

    // Update the specified resource in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|unique:departamentos,nombre,' . $id . '|max:255',
            'centro_costos_id' => 'required|exists:centro_costos,id',
        ]);

        $departamento = Departamento::find($id);

        if (!$departamento) {
            return response()->json(['message' => 'Departamento no encontrado'], 404);
        }

        $departamento->update($request->all());

        return response()->json($departamento);
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {
        $departamento = Departamento::find($id);

        if (!$departamento) {
            return response()->json(['message' => 'Departamento no encontrado'], 404);
        }

        $departamento->delete();

        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Departamento;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    
    public function index()
    {
        $departamentos = Departamento::all();
        return response()->json($departamentos);
    }

    
    
    public function store(Request $request)
    {
        $messages = [
            'nombre.required' => 'El nombre es requerido.',
            'nombre.u' => 'Este nombre ya existe.',
            'nombre.max' => 'El nombre no debe exceder los 255 caracteres.',
            'centro_costos_id.required' => 'El ID del centro de costos es requerido.',
            'centro_costos_id.exists' => 'El ID del centro de costos no existe.',
        ];

        $validated = Validator::make($request->all(), [
            'nombre' => 'required|unique:departamentos|max:255',
            'centro_costos_id' => 'required|exists:centro_costos,id',
        ], $messages);

        if($validated->fails()){
            return response()->json(['message' => $validated->errors()], 400);
        }
        else{
            $departamento = Departamento::create($request->all());
            return response()->json($departamento, 201);
        }
    }
 

    
    public function show($id)
    {
        $departamento = Departamento::find($id);

        if (!$departamento) {
            return response()->json(['message' => 'Departamento no encontrado'], 404);
        }

        return response()->json($departamento);
    }

    
    
    public function update(Request $request, $id)
    {
        $messages = [
            'nombre.required' => 'El nombre es requerido.',
            'nombre.unique' => 'Este nombre ya existe.',
            'nombre.max' => 'El nombre no debe exceder los 255 caracteres.',
            'centro_costos_id.required' => 'El ID del centro de costos es requerido.',
            'centro_costos_id.exists' => 'El ID del centro de costos no existe.',
        ];

        $validated = Validator::make($request->all(), [
            'nombre' => 'required|unique:departamentos,nombre,' . $id . '|max:255',
            'centro_costos_id' => 'required|exists:centro_costos,id',
        ], $messages);

        if($validated->fails()){
            return response()->json(['message' => $validated->errors()], 400);
        }
        else{
            $departamento = Departamento::find($id);

            if (!$departamento) {
                return response()->json(['message' => 'Departamento no encontrado'], 404);
            }

            $departamento->update($request->all());

            return response()->json($departamento);
        }
    }


    
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

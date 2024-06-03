<?php

namespace App\Http\Controllers;
use App\Models\CentroCosto;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class CentroCostoController extends Controller
{
    public function index()
    {
        $centroCostos = CentroCosto::all();
        return response()->json($centroCostos);
    }

    
    public function store(Request $request)
    {
        $messages = [
            'nombre.required' => 'El nombre es requerido.',
            'nombre.unique' => 'Este número ya existe.',
            'nombre.size' => 'El nombre debe tener exactamente 6 caracteres.',
        ];

        $validated = Validator::make($request->all(),
        ['nombre' => 'required|unique:centro_costos|size:6',], $messages);

        if($validated->fails()){
            return response()->json(['message' => $validated->errors()], 400);
        }
        else{
            $centroCosto = CentroCosto::create($request->all());
            return response()->json($centroCosto, 201);
        }
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

  
    public function update(Request $request, $id)
    {
            $messages = [
                'nombre.required' => 'El nombre es requerido.',
                'nombre.unique' => 'Este número ya existe.',
                'nombre.size' => 'El nombre debe tener exactamente 6 caracteres.',
            ];

            $validated = Validator::make($request->all(),
            ['nombre' => 'required|unique:centro_costos,nombre,' . $id . '|size:6',], $messages);

            if($validated->fails()){
                return response()->json(['message' => $validated->errors()], 400);
            }
            else{
                $centroCosto = CentroCosto::find($id);

                if (!$centroCosto) {
                    return response()->json(['message' => 'Centro de costos no encontrado'], 404);
                }

                $centroCosto->update($request->all());

                return response()->json($centroCosto);
            }
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


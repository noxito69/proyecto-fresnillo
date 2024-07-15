<?php

namespace App\Http\Controllers;
use App\Models\CentroCosto;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class CentroCostoController extends Controller
{
    public function index()
    {
        $centroCostos = CentroCosto::where('is_active', true)->orderBy('nombre')->get();
        return response()->json($centroCostos);
    }

    public function indexPg(Request $request)
    {
        $query = $request->query();
        $page = (int)$query['page'];
        $perPage = (int)$query['pageSize'];

        $centroCostos = CentroCosto::orderBy('nombre')->paginate($perPage, ['*'], 'page', $page); 
        return response()->json($centroCostos);
    }

    public function search(Request $request) {
        $query = $request->input('query');
        $results = CentroCosto::where("nombre", "LIKE", "%$query%")->paginate(20);
        return response()->json($results);
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

    // Remove the specified resource from 
    public function delete($id)
    {
        $centroCosto = CentroCosto::find($id);

        if (!$centroCosto) {
            return response()->json(['message' => 'Centro de costos no encontrado'], 404);
        }

        if($centroCosto->is_active){

            $centroCosto->is_active = false;
            $centroCosto->save();
            return response()->json(['message' => 'Centro de costos deshabilitado']);

        }
        $centroCosto->is_active = true;
        $centroCosto->save();

        return response()->json(['message' => 'Departamento habilitado correctamente']);

    }
}


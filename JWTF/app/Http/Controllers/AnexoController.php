<?php

namespace App\Http\Controllers;
use App\Models\Anexo;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class AnexoController extends Controller
{
    public function index()
    {
        $anexos = Anexo::OrderBy('nombre')->get();
        return response()->json($anexos);
    }

    public function indexPg(Request $request)
    {
        $query = $request->query();
        $page = (int)$query['page'];
        $perPage = (int)$query['pageSize'];

        $anexos = Anexo::orderBy('nombre')->paginate($perPage, ['*'], 'page', $page); 
        return response()->json($anexos);
    }   
    
    public function search(Request $request) {
        $query = $request->input('query');
        $results = Anexo::where("nombre", "LIKE", "%$query%")->orWhere("fecha_caducidad","LIKE","%$query%")->paginate(20);
        return response()->json($results);
    }

    
    public function store(Request $request)
    {
        $messages = [
            'nombre.required' => 'El nombre es requerido.',
            'nombre.max' => 'El nombre no debe exceder los 255 caracteres.',
            'nombre.unique' => 'El nombre ya está en uso.',
            'fecha_caducidad.date' => 'La fecha de caducidad debe ser una fecha válida.',
            'fecha_caducidad.after_or_equal' => 'La fecha de caducidad no puede ser una fecha pasada.',
        ];

        $validated = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:anexos',
            'fecha_caducidad' => 'nullable|date|after_or_equal:today',
        ], $messages);

        if($validated->fails()){
            return response()->json(['message' => $validated->errors()], 400);
        }
        else{
            $anexo = Anexo::create($request->all());
            return response()->json($anexo, 201);
        }
    }



    public function show($id)
    {
        $anexo = Anexo::find($id);

        if (!$anexo) {
            return response()->json(['message' => 'Anexo no encontrado'], 404);
        }

        return response()->json($anexo);
    }


    
    public function update(Request $request, $id)
    {
        $messages = [
            'nombre.required' => 'El nombre es requerido.',
            'nombre.max' => 'El nombre no debe exceder los 255 caracteres.',
            'nombre.unique' => 'El nombre ya está en uso.',
            'fecha_caducidad.date' => 'La fecha de caducidad debe ser una fecha válida.',
            'fecha_caducidad.after_or_equal' => 'La fecha de caducidad no puede ser una fecha pasada.',
        ];

        $validated = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:anexos',
            'fecha_caducidad' => 'nullable|date|after_or_equal:today',
        ], $messages);

        if($validated->fails()){
            return response()->json(['message' => $validated->errors()], 400);
        }
        else{
            $anexo = Anexo::find($id);

            if (!$anexo) {
                return response()->json(['message' => 'Anexo no encontrado'], 404);
            }

            $anexo->update($request->all());

            return response()->json($anexo);
        }
    }



    public function destroy($id)
    {
        $anexo = Anexo::find($id);

        if (!$anexo) {
            return response()->json(['message' => 'Anexo no encontrado'], 404);
        }

        $anexo->delete();

        return response()->json(['message' => 'Anexo eliminado']);
    }


}

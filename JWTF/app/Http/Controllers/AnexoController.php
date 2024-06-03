<?php

namespace App\Http\Controllers;
use App\Models\Anexo;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class AnexoController extends Controller
{
    public function index()
    {
        $anexos = Anexo::all();
        return response()->json($anexos);
    }

    
    public function store(Request $request)
    {
        $messages = [
            'nombre.required' => 'El nombre es requerido.',
            'nombre.max' => 'El nombre no debe exceder los 255 caracteres.',
            'fecha_caducidad.date' => 'La fecha de caducidad debe ser una fecha válida.',
            'fecha_caducidad.after_or_equal' => 'La fecha de caducidad no puede ser una fecha pasada.',
        ];

        $validated = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
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
            'fecha_caducidad.date' => 'La fecha de caducidad debe ser una fecha válida.',
            'fecha_caducidad.after_or_equal' => 'La fecha de caducidad no puede ser una fecha pasada.',
        ];

        $validated = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
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

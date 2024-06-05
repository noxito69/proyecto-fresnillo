<?php

namespace App\Http\Controllers;
use App\Models\UsuarioPenmont;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class UsuariosPenmontController extends Controller
{
    public function index()
    {

        $usuariospenmont = UsuarioPenmont::all();
        return response()->json($usuariospenmont); 

    }

    
    public function store(Request $request)
    {
        $messages = [
            'num_empleado.required' => 'El número de empleado es requerido.',
            'num_empleado.string' => 'El número de empleado debe ser una cadena de texto.',
            'num_empleado.unique' => 'El número de empleado ya existe.',
            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo electrónico válida.',
            'nombre.required' => 'El nombre es requerido.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'departamento_id.required' => 'El ID del departamento es requerido.',
            'departamento_id.integer' => 'El ID del departamento debe ser un número entero.',
            'departamento_id.exists' => 'El ID del departamento no existe.',
        ];

        $validated = Validator::make($request->all(), [
            'num_empleado' => 'required|string|unique:usuarios_penmont,num_empleado',
            'email' => 'required|email',
            'nombre' => 'required|string',
            'departamento_id' => 'required|integer|exists:departamentos,id',
        ], $messages);

        if($validated->fails()){
            return response()->json(['message' => $validated->errors()], 400);
        }
        else{
            $usuarioPenmont = UsuarioPenmont::create($request->all());
            return response()->json([
                'message' => 'UsuarioPenmont created successfully',
                'data' => $usuarioPenmont], 201);
        }
    }
    

    public function show($id)
    {
        $usuarioPenmont = UsuarioPenmont::find($id);

        if($usuarioPenmont)
        {
            return response()->json($usuarioPenmont);
        }
        else
        {
            return response()->json([
                'message' => 'UsuarioPenmont not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $usuarioPenmont = UsuarioPenmont::find($id);

        if($usuarioPenmont)
        {
            $messages = [
                'num_empleado.required' => 'El número de empleado es requerido.',
                'num_empleado.string' => 'El número de empleado debe ser una cadena de texto.',
                'num_empleado.unique' => 'El número de empleado ya existe.',
                'email.required' => 'El correo electrónico es requerido.',
                'email.email' => 'El correo electrónico debe ser una dirección de correo electrónico válida.',
                'nombre.required' => 'El nombre es requerido.',
                'nombre.string' => 'El nombre debe ser una cadena de texto.',
                'departamento_id.required' => 'El ID del departamento es requerido.',
                'departamento_id.integer' => 'El ID del departamento debe ser un número entero.',
                'departamento_id.exists' => 'El ID del departamento no existe.',
            ];

            $validated = Validator::make($request->all(), [
                'num_empleado' => 'required|string|unique:usuarios_penmont,num_empleado,'.$usuarioPenmont->id,
                'email' => 'required|email',
                'nombre' => 'required|string',
                'departamento_id' => 'required|integer|exists:departamentos,id',
            ], $messages);

            if($validated->fails()){
                return response()->json(['message' => $validated->errors()], 400);
            }
            else{
                $usuarioPenmont->update($request->all());
                return response()->json([
                    'message' => 'UsuarioPenmont updated successfully',
                    'data' => $usuarioPenmont], 200);
            }
        }
        else
        {
            return response()->json([
                'message' => 'UsuarioPenmont not found'
            ], 404);
        }
    }

    public function destroy($id)
    {
        $usuarioPenmont = UsuarioPenmont::find($id);

        if($usuarioPenmont)
        {
            $usuarioPenmont->delete();
            return response()->json([
                'message' => 'UsuarioPenmont deleted successfully'
            ]);
        }
        else
        {
            return response()->json([
                'message' => 'UsuarioPenmont not found'
            ], 404);
        }
    }
}

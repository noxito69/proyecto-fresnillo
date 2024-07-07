<?php

namespace App\Http\Controllers;
use App\Models\UsuarioPenmont;
use App\Models\Departamento;
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
            'departamento.required' => 'El departamento es requerido.',
            'centro_costos.required' => 'El centro de costos es requerido.'
           

        ];

        $validated = Validator::make($request->all(), [
            'num_empleado' => 'required|string|unique:usuarios_penmont,num_empleado',
            'email' => 'required|email',
            'nombre' => 'required|string',
            'departamento' => 'required|string',
            'centro_costos' => 'required'
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
                'departamento.required' => 'El departamento es requerido.',
                'centro_costos.required' => 'El centro de costos es requerido.'
            ];

            $validated = Validator::make($request->all(), [
                'num_empleado' => 'required|string|unique:usuarios_penmont,num_empleado,'.$usuarioPenmont->id,
                'email' => 'required|email',
                'nombre' => 'required|string',
                'departamento' => 'required|string',
                'centro_costos' => 'required'
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

    public function getByEmployeeNumber($employeeNumber)
{
    $usuarioPenmont = UsuarioPenmont::where('num_empleado', $employeeNumber)->first();

    if ($usuarioPenmont) {
        return response()->json($usuarioPenmont);
    } else {
        return response()->json([
            'message' => 'Empleado no encontrado'
        ], 404);
    }
}





  
}

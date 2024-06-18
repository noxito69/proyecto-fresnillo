<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EtiquetaEmpleado;
use Illuminate\Support\Facades\Validator;

class EtiquetasEmpleadosController extends Controller
{
    public function index()
    {
        $etiquetasempleados = EtiquetaEmpleado::all();
        return response()->json($etiquetasempleados); 
    }

    public function store(Request $request)
    {
        $messages = [
            'tipo_equipo_id.required' => 'El ID del tipo de equipo es requerido.',
            'tipo_equipo_id.integer' => 'El ID del tipo de equipo debe ser un número entero.',
            'marca_id.required' => 'El ID de la marca es requerido.',
            'marca_id.integer' => 'El ID de la marca debe ser un número entero.',
            'modelo.required' => 'El modelo es requerido.',
            'numero_serie.required' => 'El número de serie es requerido.',
            'numero_serie.string' => 'El número de serie debe ser una cadena de texto.',
            // 'numero_serie.unique' => 'El número de serie ya existe.', // Comentado
            'usuario_id.required' => 'El ID del usuario es requerido.',
            'usuario_id.integer' => 'El ID del usuario debe ser un número entero.',
            'usuario_id.exists' => 'El ID del usuario no existe.',
            'host.required' => 'El host es requerido.',
            'host.string' => 'El host debe ser una cadena de texto.',
            'equipo_id.required' => 'El ID del equipo es requerido.',
            'equipo_id.integer' => 'El ID del equipo debe ser un número entero.',
            'equipo_id.exists' => 'El ID del equipo no existe.',
            'mac.required' => 'La MAC es requerida.',
            'mac.string' => 'La MAC debe ser una cadena de texto.',
            'departamento_id.required' => 'El ID del departamento es requerido.',
            'departamento_id.integer' => 'El ID del departamento debe ser un número entero.',
            'departamento_id.exists' => 'El ID del departamento no existe.',
        ];
        
        $validated = Validator::make($request->all(), [

            'modelo' => 'required|string',
            'tipo_equipo_id' => 'required|integer',
            'marca_id' => 'required|integer',
            'numero_serie' => 'required|string',
            'usuario_id' => 'required|integer|exists:usuarios_penmont,id',
            'host' => 'required|string',
            'mac' => 'required|string',
            'departamento_id' => 'required|integer|exists:departamentos,id',
            'anexo_id' => 'required|integer|exists:anexos,id',
            'fecha_vigencia' => 'required|date',
            'fecha_actual' => 'required|date'
        ], $messages);

        if($validated->fails()){
            return response()->json(['message' => $validated->errors()], 400);
        }
        else{
            $etiquetaEmpleado = EtiquetaEmpleado::create($request->all());
            return response()->json([
                'message' => 'EtiquetaEmpleado created successfully',
                'data' => $etiquetaEmpleado], 201);
        }
    }

    public function show($id)
    {
        $etiquetaEmpleado = EtiquetaEmpleado::find($id);
        if($etiquetaEmpleado == null){
            return response()->json([
                'message' => 'EtiquetaEmpleado not found',
                'data' => null], 404);
        }
        return response()->json($etiquetaEmpleado);
    }


    public function update(Request $request, $id)
    {
        $etiquetaEmpleado = EtiquetaEmpleado::find($id);

        if($etiquetaEmpleado)
        {
            $messages = [

                'modelo.required' => 'El modelo es requerido.',
                'tipo_equipo_id.required' => 'El ID del tipo de equipo es requerido.',
                'tipo_equipo_id.integer' => 'El ID del tipo de equipo debe ser un número entero.',
                'marca_id.required' => 'El ID de la marca es requerido.',
                'marca_id.integer' => 'El ID de la marca debe ser un número entero.',
                'numero_serie.required' => 'El número de serie es requerido.',
                'numero_serie.string' => 'El número de serie debe ser una cadena de texto.',
                'numero_serie.unique' => 'El número de serie ya existe.',
                'usuario_id.required' => 'El ID del usuario es requerido.',
                'usuario_id.integer' => 'El ID del usuario debe ser un número entero.',
                'usuario_id.exists' => 'El ID del usuario no existe.',
                'host.required' => 'El host es requerido.',
                'host.string' => 'El host debe ser una cadena de texto.',
                'mac.required' => 'La MAC es requerida.',
                'mac.string' => 'La MAC debe ser una cadena de texto.',
                'departamento_id.required' => 'El ID del departamento es requerido.',
                'departamento_id.integer' => 'El ID del departamento debe ser un número entero.',
                'departamento_id.exists' => 'El ID del departamento no existe.',
                'anexo_id.required' => 'El ID del anexo es requerido.',
                'anexo_id.integer' => 'El ID del anexo debe ser un número entero.',
                'anexo_id.exists' => 'El ID del anexo no existe.',
                'fecha_vigencia.required' => 'La fecha de vigencia es requerida.',
                'fecha_vigencia.date' => 'La fecha de vigencia debe ser una fecha válida.',
            ];

            $validated = Validator::make($request->all(), [
                'tipo_equipo_id' => 'required|integer',
                'marca_id' => 'required|integer',
                'modelo' => 'required|string', // Agregado
                'numero_serie' => 'required|string|unique:etiquetas_empleados,numero_serie,'.$etiquetaEmpleado->id,
                'usuario_id' => 'required|integer|exists:usuarios_penmont,id',
                'host' => 'required|string',
                'mac' => 'required|string',
                'departamento_id' => 'required|integer|exists:departamentos,id',
                'anexo_id' => 'required|integer|exists:anexos,id',
                'fecha_vigencia' => 'required|date',
                'fecha_actual' => 'required|date'
                
            ], $messages);

            if($validated->fails()){
                return response()->json(['message' => $validated->errors()], 400);
            }
            else{
                $etiquetaEmpleado->update($request->all());
                return response()->json([
                    'message' => 'EtiquetaEmpleado updated successfully',
                    'data' => $etiquetaEmpleado], 200);
            }
        }
        else
        {
            return response()->json([
                'message' => 'EtiquetaEmpleado not found'
            ], 404);
        }
    }

    public function destroy($id)
    {
        $etiquetaEmpleado = EtiquetaEmpleado::find($id);
        if($etiquetaEmpleado == null){
            return response()->json([
                'message' => 'EtiquetaEmpleado not found',
                'data' => null], 404);
        }
        $etiquetaEmpleado->delete();
        return response()->json([
            'message' => 'EtiquetaEmpleado deleted successfully',
            'data' => $etiquetaEmpleado], 200);
    }

    
}

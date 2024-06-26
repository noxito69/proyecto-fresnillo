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


            'modelo.required' => 'El modelo es requerido.',
            'numero_serie.required' => 'El número de serie es requerido.',
            'numero_serie.string' => 'El número de serie debe ser una cadena de texto.',
            'numero_serie.unique' => 'El número de serie ya existe.',
            'anexo.required' => 'El anexo es requerido.',
            'departamento.required' => 'El departamento es requerido.',
            'usuario.required' => 'El ID del usuario es requerido.',
            // 'numero_serie.unique' => 'El número de serie ya existe.', // Comentado
            'usuario.required' => 'El usuario es requerido.',
            'host.required' => 'El host es requerido.',
            'host.string' => 'El host debe ser una cadena de texto.',
            'mac.required' => 'La MAC es requerida.',
            'mac.string' => 'La MAC debe ser una cadena de texto.',
        ];
        
        $validated = Validator::make($request->all(), [

            'modelo' => 'required|string',
            'numero_serie' => 'required|string',
            'usuario' => 'required|string',
            'host' => 'required|string',
            'mac' => 'required|string',
            'departamento' => 'required|string',
            'anexo' => 'required|string',
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
                'numero_serie.required' => 'El número de serie es requerido.',
                'numero_serie.string' => 'El número de serie debe ser una cadena de texto.',
                'numero_serie.unique' => 'El número de serie ya existe.',
                'usuario.required' => 'El ID del usuario es requerido.',
                'host.required' => 'El host es requerido.',
                'host.string' => 'El host debe ser una cadena de texto.',
                'mac.required' => 'La MAC es requerida.',
                'mac.string' => 'La MAC debe ser una cadena de texto.',
                'departamento.required' => 'El departamento es requerido.',
                'anexo.required' => 'El anexo es requerido.',
                'fecha_vigencia.required' => 'La fecha de vigencia es requerida.',
                'fecha_vigencia.date' => 'La fecha de vigencia debe ser una fecha válida.',
            ];

            $validated = Validator::make($request->all(), [
            
                'modelo' => 'required|string', // Agregado
                'numero_serie' => 'required|string|unique:etiquetas_empleados,numero_serie,'.$etiquetaEmpleado->id,
                'usuario' => 'required|string',
                'host' => 'required|string',
                'mac' => 'required|string',
                'departamento' => 'required|string',
                'anexo' => 'required|string',
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



    public function getLastEtiqueta(){
        $lastTag = EtiquetaEmpleado::all()->last();
        return response()->json(["data" => $lastTag], 200);
    }

    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EtiquetaEmpleado;
use Illuminate\Support\Facades\Validator;

class EtiquetasEmpleadosController extends Controller
{
    public function index()
    {
        $etiquetasempleados = EtiquetaEmpleado::select("*")->paginate(20, ['*'], 'page', 1);
        return response()->json($etiquetasempleados); 
    }

    public function search(Request $request) {
        $query = $request->input('query');
        $results = EtiquetaEmpleado::where("numero_etiqueta", "LIKE", "%$query%")->orWhere("usuario", "LIKE", "%$query%")->orWhere("numero_serie", "LIKE","%$query%")->paginate(20);
        return response()->json($results);
    }





    public function store(Request $request)
    {
        $messages = [



            'numero_etiqueta' => 'El número de etiqueta es requerido.',
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
            'correo.required' => 'El correo es requerido.',
        ];
        
        $validated = Validator::make($request->all(), [

            'numero_etiqueta' => 'required|integer',
            'correo' => 'required|string',
            'ip' => 'nullable|string', 
            'modelo' => 'required|string',
            'numero_serie' => 'required|string',
            'usuario' => 'required|string',
            'host' => 'required|string',
            'mac' => 'required|string',
            'departamento' => 'required|string',
            'anexo' => 'required|string',
            'fecha_vigencia' => 'required|date',


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

           
                'numero_etiqueta' => 'El número de etiqueta es requerido.',
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
                'correo.required' => 'El correo es requerido.',
            ];

            $validated = Validator::make($request->all(), [


                'correo' => 'required|string', 
                'numero_etiqueta' => 'required|integer',
                'ip' => 'nullable|string',
                'modelo' => 'required|string', // Agregado
                'numero_serie' => 'required|string|unique:etiquetas_empleados,numero_serie,'.$etiquetaEmpleado->id,
                'usuario' => 'required|string',
                'host' => 'required|string',
                'mac' => 'required|string',
                'departamento' => 'required|string',
                'anexo' => 'required|string',
                'fecha_vigencia' => 'required|date',
       
                
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




    public function getByNumeroEtiqueta($numero_etiqueta)
    {
        $etiquetaEmpleado = EtiquetaEmpleado::where('numero_etiqueta', $numero_etiqueta)->first();

        if ($etiquetaEmpleado) {
            return response()->json([
                'message' => 'EtiquetaEmpleado found',
                'data' => $etiquetaEmpleado
            ], 200);
        } else {
            return response()->json([
                'message' => 'EtiquetaEmpleado not found'
            ], 404);
        }
    }


    
}

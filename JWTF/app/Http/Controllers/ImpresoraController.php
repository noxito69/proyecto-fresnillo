<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Impresora;
use Illuminate\Support\Facades\Validator;

class ImpresoraController extends Controller
{
    public function index()
    {

        $impresoras = Impresora::all();
        return response()->json($impresoras);

    }


    
    public function store(Request $request)
    {
        $messages = [
            'numero_serie.required' => 'El número de serie es requerido.',
            'numero_serie.max' => 'El número de serie no debe exceder los 255 caracteres.',
            'departamento_id.required' => 'El ID del departamento es requerido.',
            'departamento_id.integer' => 'El ID del departamento debe ser un número entero.',
            'departamento_id.exists' => 'El departamento con este ID no existe.',
            'IP.required' => 'La IP es requerida.',
            'IP.max' => 'La IP no debe exceder los 255 caracteres.',
            'ubicacion.required' => 'La ubicación es requerida.',
            'ubicacion.max' => 'La ubicación no debe exceder los 255 caracteres.',
        ];

        $validated = Validator::make($request->all(), [
            'numero_serie' => 'required|max:255',
            'departamento_id' => 'required|integer|exists:departamentos,id',
            'IP' => 'required|max:255',
            'ubicacion' => 'required|max:255',
        ], $messages);

        if($validated->fails()){
            return response()->json(['message' => $validated->errors()], 400);
        }
        else{
            $impresora = Impresora::create($request->all());
            return response()->json([
                'message' => 'Impresora created successfully',
                'data' => $impresora], 201);
        }
    }




    public function show($id)
    {

        $impresora = Impresora::find($id);

        if($impresora)

        {

            return response()->json($impresora);

        }

        else

        {

            return response()->json([

                'message' => 'Impresora not found'

            ], 404);

        }

    }

    public function update(Request $request, $id)
    {

        $impresora = Impresora::find($id);

        if($impresora)

        {

            $request->validate([

                
                'numero_serie' => 'required|max:255',
                'departamento_id' => 'required|integer',
                'IP' => 'required|max:255',
                'ubicacion' => 'required|max:255'

            ]);

            $impresora->update($request->all());

            return response()->json([

                'message' => 'Impresora updated successfully',
                'data' => $impresora

            ], 200);

        }

        else

        {

            return response()->json([

                'message' => 'Impresora not found'

            ], 404);

        }

    }

    public function destroy($id)
    {

        $impresora = Impresora::find($id);

        if($impresora)

        {

            $impresora->delete();

            return response()->json([

                'message' => 'Impresora deleted successfully'

            ], 200);

        }

        else

        {

            return response()->json([

                'message' => 'Impresora not found'

            ], 404);

        }

    }
}

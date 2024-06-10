<?php

namespace App\Http\Controllers;
use App\Models\Historial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HistorialController extends Controller
{
    public function index()
    {
        $historial = Historial::join('accesorios', 'historial.articulo_id', '=', 'accesorios.id')
                              ->select('historial.*', 'accesorios.articulo', 'accesorios.marca') // Selecciona los campos necesarios
                              ->get();
                            return response()->json($historial);
    }

    public function store(Request $request)
    {
        $messages = [
            'num_empleado.required' => 'El número de empleado es requerido.',
            'num_empleado.numeric' => 'El número de empleado debe ser un número.',
            'usuario.required' => 'El usuario es requerido.',
            'articulo_id.required' => 'El ID del artículo es requerido.',
            'articulo_id.numeric' => 'El ID del artículo debe ser un número.',
            'cantidad.required' => 'La cantidad es requerida.',
            'cantidad.numeric' => 'La cantidad debe ser un número.',
            'departamento.required' => 'El departamento es requerido.',
            'centro_costos.required' => 'El centro de costos es requerido.',
        ];

        $validate = Validator::make($request->all(), [
            'num_empleado' => 'required|numeric',
            'usuario' => 'required',
            'articulo_id' => 'required|numeric',
            'cantidad' => 'required|numeric',
            'departamento' => 'required',
            'centro_costos' => 'required'
        ], $messages);

        if($validate->fails()){
            return response()->json(['error' => $validate->errors()], 422);
        }

        try {
            $historial = new Historial();

            $historial->num_empleado = $request->num_empleado;
            $historial->usuario = $request->usuario;
            $historial->articulo_id = $request->articulo_id;
            $historial->cantidad = $request->cantidad;
            $historial->departamento = $request->departamento;
            $historial->centro_costos = $request->centro_costos;

            $historial->save();

            return response()->json($historial, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al guardar el historial'], 500);
        }
    }


    public function show($id)
    {

        $historial = Historial::find($id);

        if ($historial) {
            return response()->json($historial);
        } else {
            return response()->json([
                'message' => 'Historial not found'
            ], 404);
        }

    }

    public function update(Request $request, $id)
    {

        $historial = Historial::find($id);

        if ($historial) {

            $request->validate([
                
                'num_empleado' => 'required|numeric',
                'usuario' => 'required|string',
                'articulo_id' => 'required|numeric',
                'cantidad' => 'required|numeric',
                'departamento_id' => 'required|numeric',
                'centro_costos_id' => 'required|numeric'
            ]);

            $historial->update($request->all());

            return response()->json([
                'message' => 'Historial updated successfully',
                'data' => $historial
            ]);

        } else {
            return response()->json([
                'message' => 'Historial not found'
            ], 404);
        }

    }

    public function destroy($id)
    {

        $historial = Historial::find($id);

        if ($historial) {
            $historial->delete();

            return response()->json([
                'message' => 'Historial deleted successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'Historial not found'
            ], 404);
        }

    }

    
}

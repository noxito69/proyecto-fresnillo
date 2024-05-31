<?php

namespace App\Http\Controllers;
use App\Models\Historial;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    public function index()
    {

        $historial = Historial::all();
        return response()->json($historial);

    }

    public function store(Request $request)
    {

        $request->validate([
            'fecha' => 'required|date',
            'num_empleado' => 'required|numeric',
            'usuario' => 'required|string',
            'articulo_id' => 'required|numeric',
            'cantidad' => 'required|numeric',
            'departamento_id' => 'required|numeric',
            'centro_costos_id' => 'required|numeric'
          
        ]);

        $historial = Historial::create($request->all());

        return response()->json([
            'message' => 'Historial created successfully',
            'data' => $historial], 201);

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
                'fecha' => 'required|date',
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

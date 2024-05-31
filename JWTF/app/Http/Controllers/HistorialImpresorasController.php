<?php

namespace App\Http\Controllers;
use App\Models\HistorialImpresora;
use Illuminate\Http\Request;

class HistorialImpresorasController extends Controller
{
    
    public function index()
    {

        $historialImpresoras = HistorialImpresora::all();
        return response()->json($historialImpresoras);

    } 
    
    public function store(Request $request)
    {

        $request->validate([

            'fecha' => 'required|date',
            'cantidad' => 'required|integer',
            'departamento_id' => 'required|integer',
            'impresora_id' => 'required|integer',
            'centro_costos_id' => 'required|integer'

        ]);

        $historialImpresora = HistorialImpresora::create($request->all());
        return response()->json([

            'message' => 'HistorialImpresora created successfully',
            'data' => $historialImpresora], 201);

    }

    public function show($id)
    {

        $historialImpresora = HistorialImpresora::find($id);
        if($historialImpresora == null){

            return response()->json([

                'message' => 'HistorialImpresora not found',
                'data' => null], 404);

        }
        return response()->json([

            'message' => 'HistorialImpresora found',
            'data' => $historialImpresora], 200);

    }

    public function update(Request $request, $id)
    {

        $historialImpresora=HistorialImpresora::find($id);

        if($historialImpresora)
        {
            $historialImpresora->update($request->all());
            return response()->json([

                'message' => 'HistorialImpresora updated successfully',
                'data' => $historialImpresora], 200);

        }
        else
        {

            return response()->json([

                'message' => 'HistorialImpresora not found',
                'data' => null], 404);

        }
    }

    public function destroy($id)
    {

        $historialImpresora = HistorialImpresora::find($id);
        if($historialImpresora)
        {
            $historialImpresora->delete();
            return response()->json([

                'message' => 'HistorialImpresora deleted successfully',
                'data' => $historialImpresora], 200);

        }
        else
        {

            return response()->json([

                'message' => 'HistorialImpresora not found',
                'data' => null], 404);

        }
    }

}

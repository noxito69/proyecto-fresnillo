<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EtiquetaEmpleado;

class EtiquetasEmpleadosController extends Controller
{
    public function index()
    {
        $etiquetasempleados = EtiquetaEmpleado::all();
        return response()->json($etiquetasempleados); 
    }

    public function store(Request $request)
    {
        $request->validate([
           
            'numero_serie' => 'required|string',
            'usuario_id' => 'required|integer',
            'host' => 'required|string',
            'equipo_id' => 'required|integer',
            'mac' => 'required|string',
            'departamento_id' => 'required|integer',
            'anexo_id' => 'required|integer',
            'fecha_vigencia' => 'required|date',
        ]);
    
        $etiquetaEmpleado = EtiquetaEmpleado::create($request->all());

        return response()->json([
            'message' => 'EtiquetaEmpleado created successfully',
            'data' => $etiquetaEmpleado], 201);
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
        $request->validate([
            'numero_serie' => 'required|string',
            'usuario_id' => 'required|integer',
            'host' => 'required|string',
            'equipo_id' => 'required|integer',
            'mac' => 'required|string',
            'departamento_id' => 'required|integer',
            'anexo_id' => 'required|integer',
            'fecha_vigencia' => 'required|date',
        ]);

        $etiquetaEmpleado = EtiquetaEmpleado::find($id);
        if($etiquetaEmpleado == null){
            return response()->json([
                'message' => 'EtiquetaEmpleado not found',
                'data' => null], 404);
        }
        $etiquetaEmpleado->update($request->all());
        return response()->json([
            'message' => 'EtiquetaEmpleado updated successfully',
            'data' => $etiquetaEmpleado], 200);
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

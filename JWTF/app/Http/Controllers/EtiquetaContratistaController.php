<?php

namespace App\Http\Controllers;
use App\Models\EtiquetaContratista;

use Illuminate\Http\Request;

class EtiquetaContratistaController extends Controller
{
    public function index()
    {
        $etiquetasContratistas = EtiquetaContratista::all();
        return response()->json($etiquetasContratistas);
    }

    public function store(Request $request)
    {
        $request->validate([
           
            'modelo' => 'required|max:255',
            'tipo_equipo_id' => 'required|integer',
            'marca_id' => 'required|integer',
            'numero_serie' => 'required|max:255',
            'usuario' => 'required|max:255',
            'empresa_id' => 'required|integer',
            'fecha_vigencia' => 'required|date',
            'fecha_actual' => 'required|date'
            
            
        ]);

        $etiquetaContratista = EtiquetaContratista::create($request->all());

        return response()->json([
            'message' => 'EtiquetaContratista created successfully',
            'data' => $etiquetaContratista], 201);
    }

    public function show($id)
    {
        $etiquetaContratista = EtiquetaContratista::find($id);

        if($etiquetaContratista)
        {
            return response()->json($etiquetaContratista);
        }
        else
        {
            return response()->json([
                'message' => 'EtiquetaContratista not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $etiquetaContratista = EtiquetaContratista::find($id);

        if($etiquetaContratista)
        {
            $etiquetaContratista->update($request->all());
            return response()->json([
                'message' => 'EtiquetaContratista updated successfully',
                'data' => $etiquetaContratista
            ]);
        }
        else
        {
            return response()->json([
                'message' => 'EtiquetaContratista not found'
            ], 404);
        }
    }

    public function destroy($id)
    {
        $etiquetaContratista = EtiquetaContratista::find($id);

        if($etiquetaContratista)
        {
            $etiquetaContratista->delete();
            return response()->json([
                'message' => 'EtiquetaContratista deleted successfully'
            ]);
        }
        else
        {
            return response()->json([
                'message' => 'EtiquetaContratista not found'
            ], 404);
        }
    }
}

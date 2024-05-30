<?php

namespace App\Http\Controllers;
use App\Models\EmpresaContratista;

use Illuminate\Http\Request;

class EmpresaContratistaController extends Controller
{
    public function index()
    {
        $empresaContratistas = EmpresaContratista::all();
        return response()->json($empresaContratistas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:empresa_contratistas|max:255',
        ]);

        $empresaContratista = EmpresaContratista::create($request->all());

        return response()->json([
            'message' => 'Empresa contratista created successfully',
            'data' => $empresaContratista], 201);
    }

    public function show($id)
    {
        $empresaContratista = EmpresaContratista::find($id);

        if (!$empresaContratista) {
            return response()->json(['message' => 'Empresa contratista not found'], 404);
        }

        return response()->json($empresaContratista);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|unique:empresa_contratistas,nombre,' . $id . '|max:255',
        ]);

        $empresaContratista = EmpresaContratista::find($id);

        if (!$empresaContratista) {
            return response()->json(['message' => 'Empresa contratista not found'], 404);
        }

        $empresaContratista->update($request->all());

        return response()->json([
            'message' => 'Empresa contratista updated successfully',
            'data' => $empresaContratista], 200);
    }

    public function destroy($id)
    {
        $empresaContratista = EmpresaContratista::find($id);

        if (!$empresaContratista) {
            return response()->json(['message' => 'Empresa contratista not found'], 404);
        }

        $empresaContratista->delete();

        return response()->json(['message' => 'Empresa contratista deleted successfully'], 200);
    }
}

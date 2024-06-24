<?php

namespace App\Http\Controllers;
use App\Models\EmpresaContratista;
use Illuminate\Support\Facades\Validator;

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
        $messages = [
            'nombre.required' => 'El nombre es requerido.',
            'nombre.unique' => 'Este nombre ya existe.',
            'nombre.max' => 'El nombre no debe exceder los 255 caracteres.',
        ];

        $validated = Validator::make($request->all(), [
            'nombre' => 'required|unique:empresa_contratistas|max:255',
        ], $messages);

        if($validated->fails()){
            return response()->json(['message' => $validated->errors()], 400);
        }
        else{
            $empresaContratista = EmpresaContratista::create($request->all());
            return response()->json([
                'message' => 'Empresa contratista created successfully',
                'data' => $empresaContratista], 201);
        }
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
        $messages = [
            'nombre.required' => 'El nombre es requerido.',
            'nombre.unique' => 'Este nombre ya existe.',
            'nombre.max' => 'El nombre no debe exceder los 255 caracteres.',
        ];

        $validated = Validator::make($request->all(), [
            'nombre' => 'required|unique:empresa_contratistas,nombre,' . $id . '|max:255',
        ], $messages);

        if($validated->fails()){
            return response()->json(['message' => $validated->errors()], 400);
        }
        else{
            $empresaContratista = EmpresaContratista::find($id);

            if (!$empresaContratista) {
                return response()->json(['message' => 'Empresa contratista not found'], 404);
            }

            $empresaContratista->update($request->all());

            return response()->json([
                'message' => 'Empresa contratista updated successfully',
                'data' => $empresaContratista], 200);
        }
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

    public function indexAlphabetically()
{
    $empresasContratistas = EmpresaContratista::orderBy('nombre', 'asc')->get();

    return response()->json([
        'message' => 'Empresas contratistas retrieved successfully',
        'data' => $empresasContratistas
    ], 200);
}
}

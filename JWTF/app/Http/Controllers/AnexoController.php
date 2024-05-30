<?php

namespace App\Http\Controllers;
use App\Models\Anexo;

use Illuminate\Http\Request;

class AnexoController extends Controller
{
    public function index()
    {
        $anexos = Anexo::all();
        return response()->json($anexos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_caducidad' => 'nullable|date'
         
        ]);

        $anexo = Anexo::create($request->all());

        return response()->json($anexo, 201);
    }


    public function show($id)
    {
        $anexo = Anexo::find($id);

        if (!$anexo) {
            return response()->json(['message' => 'Anexo no encontrado'], 404);
        }

        return response()->json($anexo);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_caducidad' => 'nullable|date'
        ]);

        $anexo = Anexo::find($id);

        if (!$anexo) {
            return response()->json(['message' => 'Anexo no encontrado'], 404);
        }

        $anexo->update($request->all());

        return response()->json($anexo);
    }


    public function destroy($id)
    {
        $anexo = Anexo::find($id);

        if (!$anexo) {
            return response()->json(['message' => 'Anexo no encontrado'], 404);
        }

        $anexo->delete();

        return response()->json(['message' => 'Anexo eliminado']);
    }


}

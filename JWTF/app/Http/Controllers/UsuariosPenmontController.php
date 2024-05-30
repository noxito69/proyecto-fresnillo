<?php

namespace App\Http\Controllers;
use App\Models\UsuarioPenmont;

use Illuminate\Http\Request;

class UsuariosPenmontController extends Controller
{
    public function index()
    {

        $usuariospenmont = UsuarioPenmont::all();
        return response()->json($usuariospenmont); 

    }

    

    public function store(Request $request)
    {

        $request->validate([

            'num_empleado' => 'required|string',
            'email' => 'required|email',
            'nombre' => 'required|string',
            'departamento_id' => 'required|integer'
        ]);
    
        $usuarioPenmont = UsuarioPenmont::create($request->all());

        return response()->json([
            'message' => 'UsuarioPenmont created successfully',
            'data' => $usuarioPenmont], 201);
    }

    public function show($id)
    {
        $usuarioPenmont = UsuarioPenmont::find($id);

        if($usuarioPenmont)
        {
            return response()->json($usuarioPenmont);
        }
        else
        {
            return response()->json([
                'message' => 'UsuarioPenmont not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $usuarioPenmont = UsuarioPenmont::find($id);

        if($usuarioPenmont)
        {
            $usuarioPenmont->update($request->all());
            return response()->json([
                'message' => 'UsuarioPenmont updated successfully',
                'data' => $usuarioPenmont
            ]);
        }
        else
        {
            return response()->json([
                'message' => 'UsuarioPenmont not found'
            ], 404);
        }
    }

    public function destroy($id)
    {
        $usuarioPenmont = UsuarioPenmont::find($id);

        if($usuarioPenmont)
        {
            $usuarioPenmont->delete();
            return response()->json([
                'message' => 'UsuarioPenmont deleted successfully'
            ]);
        }
        else
        {
            return response()->json([
                'message' => 'UsuarioPenmont not found'
            ], 404);
        }
    }
}

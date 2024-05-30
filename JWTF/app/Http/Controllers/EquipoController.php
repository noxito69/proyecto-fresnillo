<?php

namespace App\Http\Controllers;
use App\Models\Equipo;

use Illuminate\Http\Request;

class EquipoController extends Controller
{
    public function index()
    
    {

        $equipos = Equipo::all();
        return response()->json($equipos);

    }

    public function store(Request $request)
    {
        $request->validate([

            'modelo' => 'required|max:255',
            'marca' => 'required|max:255',
            'tipo' => 'required|max:255',
       
        ]);

        $equipo = Equipo::create($request->all());

        return response()->json([
            'message' => 'Equipo created successfully',
            'data' => $equipo], 201);
    }

    public function show($id)
    {
        $equipo = Equipo::find($id);

        if($equipo)
        {
            return response()->json($equipo);
        }
        else
        {
            return response()->json([
                'message' => 'Equipo not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $equipo = Equipo::find($id);

        if($equipo)
        {
            $equipo->update($request->all());
            return response()->json([
                'message' => 'Equipo updated successfully',
                'data' => $equipo
            ]);
        }
        else
        {
            return response()->json([
                'message' => 'Equipo not found'
            ], 404);
        }
    }

    public function destroy($id)
    {
        $equipo = Equipo::find($id);

        if($equipo)
        {
            $equipo->delete();
            return response()->json([
                'message' => 'Equipo deleted successfully'
            ]);
        }
        else
        {
            return response()->json([
                'message' => 'Equipo not found'
            ], 404);
        }
    }
}

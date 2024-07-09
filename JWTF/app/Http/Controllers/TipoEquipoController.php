<?php

namespace App\Http\Controllers;

use App\Models\TipoEquipo;
use Illuminate\Http\Request;

class TipoEquipoController extends Controller
{
    
    public function index()
    {
        $tipoequipos = TipoEquipo::all();
        return response()->json($tipoequipos);
    }

    public function paginatedIndex(Request $request){

        $query = $request->query();

        $page = (int)$query['page'];
        $perPage = (int)$query['pageSize'];


        $tipoequipos = TipoEquipo::select('*')->paginate($perPage, ['*'], 'page', $page); 
        return response()->json($tipoequipos);
    }


    public function search(Request $request) {
        $query = $request->input('query');
        $results = TipoEquipo::where("nombre", "LIKE", "%$query%")->paginate(20);
        return response()->json($results);
    }





    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255|unique:tipo_equipos',
       
        ]);

        $tipoequipo = TipoEquipo::create($request->all());

        return response()->json([
            'message' => 'TipoEquipo created successfully',
            'data' => $tipoequipo], 201);
    }

    public function show($id)
    {
        $tipoequipo = TipoEquipo::find($id);

        if($tipoequipo)
        {
            return response()->json($tipoequipo);
        }
        else
        {
            return response()->json([
                'message' => 'TipoEquipo not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $tipoequipo = TipoEquipo::find($id);

        if($tipoequipo)
        {
            $tipoequipo->update($request->all());
            return response()->json([
                'message' => 'TipoEquipo updated successfully',
                'data' => $tipoequipo
            ], 200);
        }
        else
        {
            return response()->json([
                'message' => 'TipoEquipo not found'
            ], 404);
        }
    }

    public function destroy($id)
    {
        $tipoequipo = TipoEquipo::find($id);

        if($tipoequipo)
        {
            $tipoequipo->delete();
            return response()->json([
                'message' => 'TipoEquipo deleted successfully'
            ], 200);
        }
        else
        {
            return response()->json([
                'message' => 'TipoEquipo not found'
            ], 404);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Impresora;

class ImpresoraController extends Controller
{
    public function index()
    {

        $impresoras = Impresora::all();
        return response()->json($impresoras);

    }

    public function store(Request $request)
    {

        $request->validate([

           
            'numero_serie' => 'required|max:255',
            'departamento_id' => 'required|integer',
            'IP' => 'required|max:255',
            'ubicacion' => 'required|max:255'

        ]);

        $impresora = Impresora::create($request->all());
        return response()->json([

            'message' => 'Impresora created successfully',
            'data' => $impresora], 201);

    }

    public function show($id)
    {

        $impresora = Impresora::find($id);

        if($impresora)

        {

            return response()->json($impresora);

        }

        else

        {

            return response()->json([

                'message' => 'Impresora not found'

            ], 404);

        }

    }

    public function update(Request $request, $id)
    {

        $impresora = Impresora::find($id);

        if($impresora)

        {

            $request->validate([

                
                'numero_serie' => 'required|max:255',
                'departamento_id' => 'required|integer',
                'IP' => 'required|max:255',
                'ubicacion' => 'required|max:255'

            ]);

            $impresora->update($request->all());

            return response()->json([

                'message' => 'Impresora updated successfully',
                'data' => $impresora

            ], 200);

        }

        else

        {

            return response()->json([

                'message' => 'Impresora not found'

            ], 404);

        }

    }

    public function destroy($id)
    {

        $impresora = Impresora::find($id);

        if($impresora)

        {

            $impresora->delete();

            return response()->json([

                'message' => 'Impresora deleted successfully'

            ], 200);

        }

        else

        {

            return response()->json([

                'message' => 'Impresora not found'

            ], 404);

        }

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tonner;

class TonnerController extends Controller
{
    public function index()

    {

        $tonners = Tonner::all();
        return response()->json($tonners);

    }

    public function store(Request $request)

    {

        $request->validate([

            'numero_guia' => 'required|max:255',
            'cantidad' => 'required|integer',
            'codigo' => 'required|max:255',
            'color' => 'required|max:255'

        ]);

        $tonner = Tonner::create($request->all());

        return response()->json([

            'message' => 'Tonner created successfully',
            'data' => $tonner], 201);

    }

    public function show($id)

    {

        $tonner = Tonner::find($id);

        if($tonner)

        {

            return response()->json($tonner);

        }

        else

        {

            return response()->json([

                'message' => 'Tonner not found'

            ], 404);

        }

    }

        
    public function update(Request $request, $id)
    {
        $tonner = Tonner::find($id);
        if($tonner)
        {
            $tonner->update($request->all());
            return response()->json([

                'message' => 'Tonner updated successfully',
                'data' => $tonner
            ]);
        }

        else

        {
            return response()->json([

                'message' => 'Tonner not found'
            ], 404);
        }

    }

    public function destroy($id)

    {

        $tonner = Tonner::find($id);

        if($tonner)

        {

            $tonner->delete();

            return response()->json([

                'message' => 'Tonner deleted successfully'

            ]);

        }

        else

        {

            return response()->json([

                'message' => 'Tonner not found'

            ], 404);

        }

    }
}

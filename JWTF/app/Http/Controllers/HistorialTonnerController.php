<?php

namespace App\Http\Controllers;
use App\Models\HistorialTonner;

use Illuminate\Http\Request;

class HistorialTonnerController extends Controller
{
    public function index()
    {

        $historialTonners = HistorialTonner::all();
        return response()->json($historialTonners);

    }

    public function store(Request $request)
    {

        $request->validate([

            'tonner_id' => 'required|integer',
            'fecha' => 'required|date',
            'cantidad' => 'required|max:255'

        ]);

        $historialTonner = HistorialTonner::create($request->all());
        return response()->json([

            'message' => 'HistorialTonner created successfully',
            'data' => $historialTonner], 201);

    }

    public function show($id)
    {

        $historialTonner = HistorialTonner::find($id);
        if($historialTonner == null){

            return response()->json([

                'message' => 'HistorialTonner not found',
                'data' => null], 404);

        }
        return response()->json([

            'message' => 'HistorialTonner found',
            'data' => $historialTonner], 200);

    }

    public function update(Request $request, $id)
    {

        $historialTonner=HistorialTonner::find($id);

        if($historialTonner)
        {

            $historialTonner->update($request->all());
            return response()->json([

                'message' => 'HistorialTonner updated successfully',
                'data' => $historialTonner], 200);

        }
        else
        {

            return response()->json([
                'message' => 'HistorialTonner not found',
                'data' => null], 404);

        }
    }

    public function destroy($id)
    {

        $historialTonner = HistorialTonner::find($id);
        if($historialTonner)
        {

            $historialTonner->delete();
            return response()->json([

                'message' => 'HistorialTonner deleted successfully',
                'data' => $historialTonner], 200);

        }
        else
        {

            return response()->json([

                'message' => 'HistorialTonner not found',
                'data' => null], 404);

        }

    }
}

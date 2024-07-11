<?php

namespace App\Http\Controllers;
use App\Models\Historial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HistorialController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query();
    
        // Obtener la página actual y la cantidad de elementos por página
        $page = isset($query['page']) ? (int)$query['page'] : 1;
        $perPage = isset($query['pageSize']) ? (int)$query['pageSize'] : 20;
    
        // Consultar y paginar resultados con join
        $historial = Historial::select(
            "historial.*", 
            "accesorios.articulo as articulo", 
            "accesorios.marca as marca"
        )
        ->join("accesorios", "historial.articulo_id", "=", "accesorios.id")
        ->paginate($perPage, ['*'], 'page', $page);
    
        return response()->json($historial);

    }

    public function search(Request $request) {
        $query = $request->input('query');
        $results = Historial::query()
            ->join('accesorios', 'historial.articulo_id', '=', 'accesorios.id')
            ->where("historial.num_empleado", "LIKE", "%$query%")
            ->orWhere("historial.usuario", "LIKE", "%$query%")
            ->orWhere("accesorios.articulo", "LIKE", "%$query%")
            ->orWhere("accesorios.marca", "LIKE", "%$query%")
            ->orWhere("historial.id", "LIKE", "%$query%")
            ->orWhere("historial.departamento", "LIKE", "%$query%")
            ->orWhere("historial.centro_costos", "LIKE", "%$query%")
            ->select('historial.*', 'accesorios.articulo as articulo', 'accesorios.marca as marca')
            ->paginate(20);
    
        return response()->json($results);
    }

    public function store(Request $request)
    {
        $messages = [
            'num_empleado.required' => 'El número de empleado es requerido.',
         
            'usuario.required' => 'El usuario es requerido.',
            'articulo_id.required' => 'El ID del artículo es requerido.',
            'articulo_id.numeric' => 'El ID del artículo debe ser un número.',
            'cantidad.required' => 'La cantidad es requerida.',
            'cantidad.numeric' => 'La cantidad debe ser un número.',
            'departamento.required' => 'El departamento es requerido.',
            'centro_costos.required' => 'El centro de costos es requerido.',
        ];

        $validate = Validator::make($request->all(), [
            'num_empleado' => 'required|string',
            'usuario' => 'required',
            'articulo_id' => 'required|numeric',
            'cantidad' => 'required|numeric',
            'departamento' => 'required',
            'centro_costos' => 'required'
        ], $messages);

        if($validate->fails()){
            return response()->json(['error' => $validate->errors()], 422);
        }

        try {
            $historial = new Historial();

            $historial->num_empleado = $request->num_empleado;
            $historial->usuario = $request->usuario;
            $historial->articulo_id = $request->articulo_id;
            $historial->cantidad = $request->cantidad;
            $historial->departamento = $request->departamento;
            $historial->centro_costos = $request->centro_costos;

            $historial->save();

            return response()->json($historial, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al guardar el historial'], 500);
        }
    }


    public function show($id)
    {

        $historial = Historial::find($id);

        if ($historial) {
            return response()->json($historial);
        } else {
            return response()->json([
                'message' => 'Historial not found'
            ], 404);
        }

    }

    public function update(Request $request, $id)
    {

        $historial = Historial::find($id);

        if ($historial) {

            $request->validate([

                'num_empleado' => 'required|numeric',
                'usuario' => 'required|string',
                'articulo_id' => 'required|numeric',
                'cantidad' => 'required|numeric',
                'departamento_id' => 'required|numeric',
                'centro_costos' => 'required|string'
            ]);

            $historial->update($request->all());

            return response()->json([
                'message' => 'Historial updated successfully',
                'data' => $historial
            ]);

        } else {
            return response()->json([
                'message' => 'Historial not found'
            ], 404);
        }

    }

    public function destroy($id)
    {

        $historial = Historial::find($id);

        if ($historial) {
            $historial->delete();

            return response()->json([
                'message' => 'Historial deleted successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'Historial not found'
            ], 404);
        }

    }


}

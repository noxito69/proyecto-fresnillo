<?php

namespace App\Http\Controllers;

use App\Models\Historial_prestamos;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;


class historial_prestamo_controller extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query();
    
        // Obtener la página actual y la cantidad de elementos por página
        $page = isset($query['page']) ? (int)$query['page'] : 1;
        $perPage = isset($query['pageSize']) ? (int)$query['pageSize'] : 20;
    
        // Consultar y paginar resultados con join
        $historial = Historial_prestamos::select(
            "historial_prestamos.*", 
            "accesorios.articulo as articulo", 
            "accesorios.marca as marca"
        )
        ->join("accesorios", "historial_prestamos.articulo_id", "=", "accesorios.id")
        ->paginate($perPage, ['*'], 'page', $page);
    
        return response()->json($historial);
    }


    public function search(Request $request) {
        $query = $request->input('query');
        $results = Historial_prestamos::query()
            ->join('accesorios', 'historial_prestamos.articulo_id', '=', 'accesorios.id')
            ->where("historial_prestamos.num_empleado", "LIKE", "%$query%")
            ->orWhere("historial_prestamos.fecha_devolucion", "LIKE", "%$query%")
            ->orWhere("historial_prestamos.usuario", "LIKE", "%$query%")
            ->orWhere("accesorios.articulo", "LIKE", "%$query%")
            ->orWhere("accesorios.marca", "LIKE", "%$query%")
            ->orWhere("historial_prestamos.fecha_devolucion", "LIKE", "%$query%")
            ->orWhere("historial_prestamos.id", "LIKE", "%$query%")
            ->select('historial_prestamos.*', 'accesorios.articulo as articulo', 'accesorios.marca as marca')
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
            'fecha_devolucion.required' => 'La fecha de devolución es requerida.'

        ];

        $validate = Validator::make($request->all(), [

            'num_empleado' => 'required|string',
            'usuario' => 'required',
            'articulo_id' => 'required|numeric',
            'cantidad' => 'required|numeric',
            'departamento' => 'required',
            'centro_costos' => 'required',
            'fecha_devolucion' => 'required'

        ], $messages);

        if($validate->fails()){
            $errors = $validate->errors();
            $errorMessages = [];
            foreach ($errors->all() as $message) {
            $errorMessages[] = $message;
            }
            return response()->json(['error' => $errorMessages], 422);
        }

        try {
            $historial = new Historial_prestamos();

            $historial->num_empleado = $request->num_empleado;
            $historial->usuario = $request->usuario;
            $historial->articulo_id = $request->articulo_id;
            $historial->cantidad = $request->cantidad;
            $historial->departamento = $request->departamento;
            $historial->centro_costos = $request->centro_costos;
            $historial->fecha_devolucion = $request->fecha_devolucion;

            $historial->save();

            return response()->json([
                'message' => 'Historial created successfully',
                'data' => $historial
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating historial',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}


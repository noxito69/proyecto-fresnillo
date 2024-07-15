<?php

namespace App\Http\Controllers;
use App\Models\Departamento;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class DepartamentoController extends Controller
{

    public function index()
    {
        $departamentos = Departamento::where('is_active', true)->orderBy('nombre')->get();
        return response()->json($departamentos);
    }


    public function indexPg(Request $request)
    {
        $query = $request->query();

        $page = (int)$query['page'];
        $perPage = (int)$query['pageSize'];

        $departamentos = Departamento::select('*')->paginate($perPage, ['*'], 'page', $page);
        return response()->json($departamentos);
    }

    public function search(Request $request) {
        $query = $request->input('query');
        $results = Departamento::where("nombre", "LIKE", "%$query%")->orWhere("centro_costos", "LIKE", "%$query%")->paginate(20);
        return response()->json($results);
    }


    public function indexAlfa(){
        $marcas = Departamento::orderBy('nombre')->get();
        return response()->json($marcas);
    }

    public function store(Request $request)
    {
        $messages = [
            'nombre.required' => 'El nombre es requerido.',
            'nombre.unique' => 'Este nombre ya existe.',
            'nombre.max' => 'El nombre no debe exceder los 255 caracteres.',
            'centro_costos.required' => 'El centro de costos es requerido.',

        ];

        $validated = Validator::make($request->all(), [

            'nombre' => 'required|unique:departamentos|max:255',
            'centro_costos' => 'required',

        ], $messages);

        if($validated->fails()){
            return response()->json(['message' => $validated->errors()], 400);
        }
        else{
            $departamento = Departamento::create($request->all());
            return response()->json($departamento, 201);
        }
    }



    public function show($id)
    {
        $departamento = Departamento::find($id);

        if (!$departamento) {
            return response()->json(['message' => 'Departamento no encontrado'], 404);
        }

        return response()->json($departamento);
    }



    public function update(Request $request, $id)
    {
        $messages = [
            'nombre.required' => 'El nombre es requerido.',
            'nombre.unique' => 'Este nombre ya existe.',
            'nombre.max' => 'El nombre no debe exceder los 255 caracteres.',
            'centro_costos.required' => 'El centro de costos es requerido.',
        ];

        $validated = Validator::make($request->all(), [
            'nombre' => 'required|unique:departamentos,nombre,' . $id . '|max:255',
            'centro_costos' => 'required',
        ], $messages);

        if($validated->fails()){
            return response()->json(['message' => $validated->errors()], 400);
        }
        else{
            $departamento = Departamento::find($id);

            if (!$departamento) {
                return response()->json(['message' => 'Departamento no encontrado'], 404);
            }

            $departamento->update($request->all());

            return response()->json($departamento);
        }
    }



    public function delete($id)
    {
        $departamento = Departamento::find($id);

        if(!$departamento) {
            return response()->json(["error" => "Departamento no encontrado"], 404);
        }

        if($departamento->is_active) {
            $departamento->is_active = false;
            $departamento->save();
            return response()->json(['message' => 'Departamento deshabilitado correctamente.']);
        }
        $departamento->is_active = true;
        $departamento->save();

        return response()->json(['message' => 'Departamento habilitado correctamente.']);

    }
}

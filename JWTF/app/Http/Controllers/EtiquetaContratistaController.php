<?php

namespace App\Http\Controllers;
use App\Models\EtiquetaContratista;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class EtiquetaContratistaController extends Controller
{
    public function index()
    {
        $etiquetasContratistas = EtiquetaContratista::all();
        return response()->json($etiquetasContratistas);
    }

    


    public function store(Request $request)
    {
        $messages = [
            'numero_etiqueta.required' => 'El número de etiqueta es requerido.',
            'modelo.required' => 'El modelo es requerido.',
            'tipo_equipo.required' => 'El tipo de equipo es requerido.',
            'marca.required' => 'La marca es requerida.',
            'numero_serie.required' => 'El número de serie es requerido.',
            'usuario.required' => 'El usuario es requerido.',
            'empresa.required' => 'La empresa es requerida.',
            'fecha_vigencia.required' => 'La fecha de vigencia es requerida.',
            'fecha_vigencia.date' => 'La fecha de vigencia debe ser una fecha válida.',
            'numero_serie.unique' => 'El número de serie ya existe.',
            'numero_etiqueta.unique' => 'El número de etiqueta ya existe.',

        ];

        $request->validate([
            'numero_etiqueta' => 'required|unique:etiquetas_contratistas|max:255',
            'modelo' => 'required|max:255',
            'tipo_equipo' => 'required|max:255',
            'marca' => 'required|max:255',
            'numero_serie' => 'required|unique:etiquetas_contratistas|max:255',
            'usuario' => 'required|max:255',
            'empresa' => 'required|max:255',
            'fecha_vigencia' => 'required|date',
        ], $messages);

        $etiquetaContratista = EtiquetaContratista::create($request->all());

        return response()->json([
            'message' => 'EtiquetaContratista created successfully',
            'data' => $etiquetaContratista], 201);
    }



    public function show($id)
    {
        $etiquetaContratista = EtiquetaContratista::find($id);

        if($etiquetaContratista)
        {
            return response()->json($etiquetaContratista);
        }
        else
        {
            return response()->json([
                'message' => 'EtiquetaContratista not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'numero_etiqueta.required' => 'El número de etiqueta es requerido.',
            'modelo.required' => 'El modelo es requerido.',
            'tipo_equipo.required' => 'El tipo de equipo es requerido.',
            'marca.required' => 'La marca es requerida.',
            'numero_serie.required' => 'El número de serie es requerido.',
            'usuario.required' => 'El usuario es requerido.',
            'empresa.required' => 'La empresa es requerida.',
            'fecha_vigencia.required' => 'La fecha de vigencia es requerida.',
            'fecha_vigencia.date' => 'La fecha de vigencia debe ser una fecha válida.',
            'numero_serie.unique' => 'El número de serie ya existe en otro registro.',
            'numero_etiqueta.unique' => 'El número de etiqueta ya existe en otro registro.',
        ];

        $request->validate([
            'numero_etiqueta' => 'required|unique:etiquetas_contratistas,numero_etiqueta,' . $id . '|max:255',
            'modelo' => 'required|max:255',
            'tipo_equipo' => 'required|max:255',
            'marca' => 'required|max:255',
            'numero_serie' => 'required|unique:etiquetas_contratistas,numero_serie,' . $id . '|max:255',
            'usuario' => 'required|max:255',
            'empresa' => 'required|max:255',
            'fecha_vigencia' => 'required|date',
        ], $messages);

        $etiquetaContratista = EtiquetaContratista::find($id);

        if (!$etiquetaContratista) {
            return response()->json(['message' => 'EtiquetaContratista not found'], 404);
        }

        $etiquetaContratista->update($request->all());

        return response()->json([
            'message' => 'EtiquetaContratista updated successfully',
            'data' => $etiquetaContratista
        ]);
    }



    
    public function destroy($id)
    {
        $etiquetaContratista = EtiquetaContratista::find($id);

        if($etiquetaContratista)
        {
            $etiquetaContratista->delete();
            return response()->json([
                'message' => 'EtiquetaContratista deleted successfully'
            ]);
        }
        else
        {
            return response()->json([
                'message' => 'EtiquetaContratista not found'
            ], 404);
        }
    }

    public function getLastEtiqueta(){
        $lastTag = EtiquetaContratista::all()->last();
        return response()->json(["data" => $lastTag], 200);
    }




    public function empresa_equipos()
    {
        $currentYear = now()->year; // Obtén el año actual
    
        $companies = EtiquetaContratista::select('empresa', 'tipo_equipo')
            ->selectRaw('count(*) as total')
            ->selectRaw("SUM(CASE WHEN YEAR(fecha_vigencia) >= $currentYear THEN 1 ELSE 0 END) as vigentes") // Suma condicional para contar solo las etiquetas vigentes
            ->groupBy('empresa', 'tipo_equipo')
            ->get();
    
        $result = [];
        foreach ($companies as $company) {
            // Inicializa la empresa si aún no existe en el resultado
            if (!isset($result[$company->empresa])) {
                $result[$company->empresa] = [
                    'total_vigentes' => 0, // Inicializa el total de vigentes por empresa
                    'tipos_equipo' => [] // Inicializa los tipos de equipo
                ];
            }
    
            // Agrega el tipo de equipo y sus detalles
            $result[$company->empresa]['tipos_equipo'][] = [
                'tipo_equipo' => $company->tipo_equipo,
                'total' => $company->total,
              
            ];
    
            // Suma al total de vigentes por empresa
            $result[$company->empresa]['total_vigentes'] += $company->vigentes;
        }
    
        return response()->json($result);
    }
    


    public function grafica_grande()
{
    $companies = EtiquetaContratista::select('empresa', DB::raw('count(*) as total'))
            ->groupBy('empresa')
            ->get();

        return $companies;
}



public function getbynumer($numero_etiqueta)
{
    $etiquetaContratista = EtiquetaContratista::where('numero_etiqueta', $numero_etiqueta)->first();

    if($etiquetaContratista)
    {
        return response()->json($etiquetaContratista);
    }
    else
    {
        return response()->json([
            'message' => 'EtiquetaContratista not found'
        ], 404);
    }
}



   


    

}


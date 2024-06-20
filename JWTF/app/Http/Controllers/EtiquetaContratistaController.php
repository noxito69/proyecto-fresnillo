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
        $request->validate([
            
            'numero_etiqueta' => 'required|max:255',
            'modelo' => 'required|max:255',
            'tipo_equipo' => 'required|max:255',
            'marca' => 'required|max:255',
            'numero_serie' => 'required|max:255',
            'usuario' => 'required|max:255',
            'empresa' => 'required|max:255',
            'fecha_vigencia' => 'required|date',
        


        ]);

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
        $etiquetaContratista = EtiquetaContratista::find($id);

        if($etiquetaContratista)
        {
            $etiquetaContratista->update($request->all());
            return response()->json([
                'message' => 'EtiquetaContratista updated successfully',
                'data' => $etiquetaContratista
            ]);
        }
        else
        {
            return response()->json([
                'message' => 'EtiquetaContratista not found'
            ], 404);
        }
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
        $companies = EtiquetaContratista::select('empresa', EtiquetaContratista::raw('count(*) as total'))
            ->groupBy('empresa')
            ->get();

        return $companies;
    }

    



    public function importar(Request $request)
    {
        // Validar el archivo subido
        $validated = $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        // Obtener el archivo
        $file = $request->file('file');
        $filePath = $file->getRealPath();

        // Leer el contenido del archivo CSV con el delimitador correcto
        $file = fopen($filePath, 'r');
        $header = fgetcsv($file, 0, ';');

        // Normalizar los encabezados
        $header = array_map('strtolower', $header);
        $header = array_map('trim', $header);

        $processedEtiquetas = [];
        while (($row = fgetcsv($file, 0, ';')) !== FALSE) {
            $row = array_map('trim', $row);
            $rowData = array_combine($header, $row);

            // Verificar que todas las claves necesarias existen
            if (!isset($rowData['numeroetiqueta']) ||
                !isset($rowData['tipoequipo']) ||
                !isset($rowData['marcaequipo']) ||
                !isset($rowData['modeloequipo']) ||
                !isset($rowData['numeroserie']) ||
                !isset($rowData['usuario']) ||
                !isset($rowData['empresa']) ||
                !isset($rowData['fechavigencia'])) {
                Log::warning('Fila omitida debido a encabezados faltantes', $rowData);
                continue;
            }

            // Validar y ajustar la fecha
            try {
                $fechaVigencia = date('Y-m-d', strtotime($rowData['fechavigencia']));
            } catch (\Exception $e) {
                Log::error('Error al convertir la fecha', [
                    'error' => $e->getMessage(),
                    'fecha' => $rowData['fechavigencia'],
                ]);
                continue;
            }

            // Verificar duplicados en el mismo archivo CSV
            if (in_array($rowData['numeroetiqueta'], $processedEtiquetas)) {
                Log::warning('Fila omitida debido a duplicado en el archivo CSV', $rowData);
                continue;
            }

            $processedEtiquetas[] = $rowData['numeroetiqueta'];

            try {
                // Buscar si el registro ya existe
                $etiqueta = EtiquetaContratista::where('numero_etiqueta', $rowData['numeroetiqueta'])->first();

                if ($etiqueta) {
                    // Si el registro existe, actualizarlo
                    $etiqueta->update([
                        'tipo_equipo' => $rowData['tipoequipo'],
                        'marca' => $rowData['marcaequipo'],
                        'modelo' => $rowData['modeloequipo'],
                        'numero_serie' => $rowData['numeroserie'],
                        'usuario' => mb_substr($rowData['usuario'], 0, 255), // Limitar y corregir caracteres especiales
                        'empresa' => $rowData['empresa'],
                        'fecha_vigencia' => $fechaVigencia,
                    ]);
                } else {
                    // Si el registro no existe, crear uno nuevo
                    EtiquetaContratista::create([
                        'numero_etiqueta' => $rowData['numeroetiqueta'],
                        'tipo_equipo' => $rowData['tipoequipo'],
                        'marca' => $rowData['marcaequipo'],
                        'modelo' => $rowData['modeloequipo'],
                        'numero_serie' => $rowData['numeroserie'],
                        'usuario' => mb_substr($rowData['usuario'], 0, 255), // Limitar y corregir caracteres especiales
                        'empresa' => $rowData['empresa'],
                        'fecha_vigencia' => $fechaVigencia,
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Error al insertar o actualizar la fila', [
                    'error' => $e->getMessage(),
                    'data' => $rowData,
                ]);
                continue;
            }
        }

        fclose($file);

        return response()->json(['success' => 'Datos importados correctamente'], 200);
    }


    

}


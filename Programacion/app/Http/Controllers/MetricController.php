<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Metric;
use Illuminate\Support\Facades\Validator;

class MetricController extends Controller
{
    public function store(Request $request)
    {
        // El middleware 'auth:sanctum' ya ha validado el token.
        // $request->user() nos devuelve la instancia del modelo MonitoredPc autenticado.
        $monitoredPc = $request->user();

        $validator = Validator::make($request->all(), [
            'cpu_usage' => 'required|numeric|min:0|max:100',
            'ram_usage' => 'required|numeric|min:0|max:100',
            'disk_usage' => 'required|numeric|min:0|max:100',
            'cpu_temperature' => 'nullable|numeric',
            // Ya no necesitamos 'pc_identifier' del agente, porque ya sabemos quién es.
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            // Usamos la relación que definimos para crear la métrica.
            // Esto asigna automáticamente el 'monitored_pc_id'.
            $metric = $monitoredPc->metrics()->create([
                'cpu_usage' => $request->cpu_usage,
                'ram_usage' => $request->ram_usage,
                'disk_usage' => $request->disk_usage,
                'cpu_temperature' => $request->cpu_temperature,
                // Guardamos el identifier por si acaso, aunque ya lo tenemos en la tabla de PCs.
                'pc_identifier' => $monitoredPc->identifier,
            ]);

            return response()->json([
                'message' => 'Metrics received successfully!',
                'data' => $metric
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to store metrics.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HardwareSpec;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class HardwareController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Sanctum proporciona el modelo autenticado a través de user()
            $monitoredPc = $request->user();

            // --- VERIFICACIÓN CRÍTICA ---
            // Si el modelo es nulo, significa que la autenticación falló silenciosamente.
            if (!$monitoredPc) {
                Log::error('Fallo de autenticación de API: No se resolvió ningún modelo para el token proporcionado. Revisa la configuración del "guard" de la API en config/auth.php.');
                return response()->json(['message' => 'Authentication failed on server.'], 401);
            }

            $validated = $request->validate([
                'cpu' => 'required|string',
                'ram_total_gb' => 'required|integer',
                'disks' => 'required|array',
                'motherboard' => 'required|string',
            ]);

            HardwareSpec::updateOrCreate(
                ['monitored_pc_id' => $monitoredPc->id],
                $validated
            );

            return response()->json(['message' => 'Hardware specs received successfully.'], 200);
        } catch (ValidationException $e) {
            Log::error('Falló la validación para las especificaciones de hardware:', [
                'pc_identifier' => $request->user() ? $request->user()->identifier : 'unknown',
                'errors' => $e->errors(),
                'data_received' => $request->all()
            ]);
            return response()->json(['message' => 'Invalid data provided.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Falló el almacenamiento de las especificaciones de hardware:', [
                'pc_identifier' => $request->user() ? $request->user()->identifier : 'unknown',
                'error' => $e->getMessage(),
                'data_received' => $request->all()
            ]);
            return response()->json(['message' => 'An internal server error occurred.'], 500);
        }
    }
}

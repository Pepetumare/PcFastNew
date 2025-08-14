<?php

namespace App\Http\Controllers;

use App\Models\MonitoredPc;
use App\Services\RecommendationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class MonitoredPcController extends Controller
{
public function show(MonitoredPc $pc, RecommendationService $recommendationService)
    {
        $user = Auth::user();

        // Verificación de autorización
        if (!$user->isAdmin() && $pc->user_id !== $user->id) {
            abort(403, 'Acceso no autorizado.');
        }

        // Obtenemos las métricas de las últimas 24 horas.
        $metrics = $pc->metrics()
                      ->where('created_at', '>=', Carbon::now()->subDay())
                      ->orderBy('created_at', 'asc')
                      ->get();

        // Formateamos los datos para los gráficos.
        $chartLabels = $metrics->map(fn($metric) => $metric->created_at->format('H:i'));
        $cpuData = $metrics->pluck('cpu_usage');
        $ramData = $metrics->pluck('ram_usage');
        $diskData = $metrics->pluck('disk_usage');
        
        // --- LÍNEA CLAVE ---
        // Generamos las recomendaciones usando el servicio.
        $recommendations = $recommendationService->generateForPc($pc);
        
        // Pasamos todas las variables a la vista.
        return view('pcs.show', [
            'pc' => $pc->load('hardwareSpec'),
            'chartLabels' => $chartLabels,
            'cpuData' => $cpuData,
            'ramData' => $ramData,
            'diskData' => $diskData,
            'recommendations' => $recommendations, // ¡Ahora la variable se está enviando!
        ]);
    }

    public function create()
    {
        return view('pcs.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $pc = MonitoredPc::create([
            'name' => $request->name,
            'identifier' => 'pending-' . Str::random(10),
        ]);
        $token = $pc->createToken('pc-token-' . $pc->id)->plainTextToken;
        return redirect()->route('pcs.show-token', $pc->id)->with('token', $token);
    }

    public function showToken(MonitoredPc $pc)
    {
        if (!session('token')) {
            return redirect()->route('dashboard')->with('error', 'Token no disponible.');
        }
        return view('pcs.show-token', ['pc' => $pc, 'token' => session('token')]);
    }
}
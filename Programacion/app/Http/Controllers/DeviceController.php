<?php

namespace App\Http\Controllers;

use App\Models\MonitoredPc; // Seguimos usando el modelo original para los PCs
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeviceController extends Controller
{
    /**
     * Muestra el formulario para registrar un nuevo dispositivo.
     */
    public function register()
    {
        return view('devices.register');
    }

    /**
     * Guarda un nuevo dispositivo en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Creamos el registro en la tabla 'monitored_pcs'
        $pc = MonitoredPc::create([
            'name' => $request->name,
            'identifier' => 'pending-' . Str::random(10), 
            'user_id' => auth()->id(), // Asignamos el PC al admin actual
        ]);

        // Generamos el token
        $token = $pc->createToken('device-token-' . $pc->id)->plainTextToken;

        // Redirigimos a la página para mostrar el token
        return redirect()->route('devices.show-token', $pc->id)
                         ->with('token', $token);
    }

    /**
     * Muestra el token generado para el dispositivo.
     */
    public function showToken(MonitoredPc $pc)
    {
        // Usamos la sesión para asegurarnos de que el token solo se muestre una vez.
        if (!session('token')) {
            return redirect()->route('dashboard')->with('error', 'Token no disponible.');
        }

        return view('devices.show-token', [
            'pc' => $pc,
            'token' => session('token')
        ]);
    }
}

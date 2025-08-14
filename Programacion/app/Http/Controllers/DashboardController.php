<?php

namespace App\Http\Controllers;

use App\Models\MonitoredPc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard principal.
     */
    public function index()
    {
        $user = Auth::user();
        $pcs = collect(); // Creamos una colección vacía por defecto.

        if ($user->isAdmin()) {
            // Si es admin, obtiene todos los PCs.
            $pcs = MonitoredPc::with(['metrics' => function ($query) {
                $query->latest()->limit(1);
            }])->get();
        } else {
            // Si es un usuario normal, obtiene solo sus PCs.
            $pcs = $user->monitoredPcs()->with(['metrics' => function ($query) {
                $query->latest()->limit(1);
            }])->get();
        }

        return view('dashboard', ['pcs' => $pcs]);
    }
}

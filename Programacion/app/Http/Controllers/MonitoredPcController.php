<?php

namespace App\Http\Controllers;

use App\Models\MonitoredPc;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MonitoredPcController extends Controller
{
    public function show(MonitoredPc $pc)
    {
        return view('pcs.show', ['pc' => $pc]);
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
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
        {
            // Obtenemos el valor actual del logo para mostrarlo
            $logoPath = DB::table('settings')->where('key', 'logo_path')->value('value');
            return view('settings.index', compact('logoPath'));
        }

        public function update(Request $request)
        {
            $request->validate([
                'logo' => 'required|image|mimes:svg,png,jpg,jpeg,webp|max:1024', // 1MB Max
            ]);

            // Obtenemos el logo anterior para borrarlo
            $oldLogoPath = DB::table('settings')->where('key', 'logo_path')->value('value');
            if ($oldLogoPath) {
                Storage::disk('public')->delete($oldLogoPath);
            }

            // Guardamos el nuevo logo
            $path = $request->file('logo')->store('logos', 'public');

            // Actualizamos la base de datos con la nueva ruta
            DB::table('settings')->updateOrInsert(
                ['key' => 'logo_path'],
                ['value' => $path, 'created_at' => now(), 'updated_at' => now()]
            );

            return redirect()->route('settings.index')->with('success', 'Logo actualizado con éxito.');
        }
}

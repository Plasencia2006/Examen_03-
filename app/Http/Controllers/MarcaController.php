<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class MarcaController extends Controller
{
   public function index()
    {
        $marcas = Marca::all();
        return view('marcas.index', compact('marcas'));
    }

    public function create()
    {
        return view('marcas.create');
    }

    public function store(Request $request)
    {
         $request->validate([
        'nombre' => 'required',
        'pais_origen' => 'required',
        'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    ]);

    $logoPath = null;
    if ($request->hasFile('logo')) {
        $logoPath = $request->file('logo')->store('logos', 'public');
    }

    Marca::create([
        'nombre' => $request->nombre,
        'pais_origen' => $request->pais_origen,
        'logo' => $logoPath,
    ]);

    return redirect()->route('marcas.index')->with('success', 'Marca creada correctamente.');
    }

    public function edit(Marca $marca)
    {
        return view('marcas.edit', compact('marca'));
    }

    public function update(Request $request, Marca $marca)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'pais_origen' => 'required|string|max:255',
        'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    // Datos básicos
    $marca->nombre = $request->nombre;
    $marca->pais_origen = $request->pais_origen;

    // Si subieron un nuevo logo
    if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
        // Borra el logo viejo si existe
        if ($marca->logo && Storage::disk('public')->exists($marca->logo)) {
            Storage::disk('public')->delete($marca->logo);
        }

        // Guarda el nuevo logo en storage/app/public/logos
        $path = $request->file('logo')->store('logos', 'public');
        $marca->logo = $path;
    }

    $marca->save();

    return redirect()->route('marcas.index')->with('success', 'Marca actualizada correctamente.');
}

    public function destroy(Marca $marca)
    {
        $marca->delete();
        return redirect()->route('marcas.index')->with('success', 'Marca eliminada');
    }

    
}

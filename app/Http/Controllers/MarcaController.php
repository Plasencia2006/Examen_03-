<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{
    // 🔹 Mostrar todas las marcas
    public function index()
    {
        $marcas = Marca::all();
        return view('marcas.index', compact('marcas'));
    }

    // 🔹 Formulario para crear
    public function create()
    {
        return view('marcas.create');
    }

    // 🔹 Guardar nueva marca
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'pais_origen' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Guardar logo si existe
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Marca::create($validated);

        return redirect()->route('marcas.index')->with('success', 'Marca creada correctamente.');
    }

    // 🔹 Formulario para editar
    public function edit(Marca $marca)
    {
        return view('marcas.edit', compact('marca'));
    }

    // 🔹 Actualizar marca existente
    public function update(Request $request, Marca $marca)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'pais_origen' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Si subieron un nuevo logo
        if ($request->hasFile('logo')) {
            // Eliminar el logo anterior si existe
            if ($marca->logo && Storage::disk('public')->exists($marca->logo)) {
                Storage::disk('public')->delete($marca->logo);
            }

            // Guardar el nuevo logo
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $marca->update($validated);

        return redirect()->route('marcas.index')->with('success', 'Marca actualizada correctamente.');
    }

    // 🔹 Eliminar marca
    public function destroy(Marca $marca)
    {
        // Borrar logo del storage si existe
        if ($marca->logo && Storage::disk('public')->exists($marca->logo)) {
            Storage::disk('public')->delete($marca->logo);
        }

        $marca->delete();

        return redirect()->route('marcas.index')->with('success', 'Marca eliminada correctamente.');
    }
}

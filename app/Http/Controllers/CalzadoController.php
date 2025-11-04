<?php

namespace App\Http\Controllers;

use App\Models\Calzado;
use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CalzadoController extends Controller
{
    // 🔹 Mostrar todos los calzados
    public function index()
    {
        $calzados = Calzado::with('marca')->get();
        return view('calzados.index', compact('calzados'));
    }

    // 🔹 Formulario para crear
    public function create()
    {
        $marcas = Marca::all();
        return view('calzados.create', compact('marcas'));
    }

    // 🔹 Guardar nuevo calzado
    public function store(Request $request)
    {
        $validated = $request->validate([
            'modelo' => 'required|string|max:255',
            'talla' => 'required|string|max:10',
            'color' => 'required|string|max:50',
            'precio' => 'required|numeric|min:0',
            'marca_id' => 'required|exists:marcas,id',
            'imagen' => 'nullable|image|max:2048'
        ]);

        // Guardar imagen si existe
        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('calzados', 'public');
        }

        Calzado::create($validated);

        return redirect()->route('calzados.index')->with('success', 'Calzado agregado correctamente.');
    }

    // 🔹 Formulario para editar
    public function edit(Calzado $calzado)
    {
        $marcas = Marca::all();
        return view('calzados.edit', compact('calzado', 'marcas'));
    }

    // 🔹 Actualizar calzado existente
    public function update(Request $request, Calzado $calzado)
    {
        $validated = $request->validate([
            'modelo' => 'required|string|max:255',
            'talla' => 'required|string|max:10',
            'color' => 'required|string|max:50',
            'precio' => 'required|numeric|min:0',
            'marca_id' => 'required|exists:marcas,id',
            'imagen' => 'nullable|image|max:2048'
        ]);

        // Si hay nueva imagen, eliminar la anterior y subir la nueva
        if ($request->hasFile('imagen')) {
            if ($calzado->imagen && Storage::disk('public')->exists($calzado->imagen)) {
                Storage::disk('public')->delete($calzado->imagen);
            }
            $validated['imagen'] = $request->file('imagen')->store('calzados', 'public');
        }

        $calzado->update($validated);

        return redirect()->route('calzados.index')->with('success', 'Calzado actualizado correctamente.');
    }

    // 🔹 Eliminar calzado
    public function destroy(Calzado $calzado)
    {
        if ($calzado->imagen && Storage::disk('public')->exists($calzado->imagen)) {
            Storage::disk('public')->delete($calzado->imagen);
        }

        $calzado->delete();
        return redirect()->route('calzados.index')->with('success', 'Calzado eliminado correctamente.');
    }
}

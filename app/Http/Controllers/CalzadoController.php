<?php

namespace App\Http\Controllers;

use App\Models\Calzado;
use App\Models\Marca;
use Illuminate\Http\Request;

class CalzadoController extends Controller
{
     public function index()
    {
        $calzados = Calzado::with('marca')->get();
        return view('calzados.index', compact('calzados'));
    }

    public function create()
    {
        $marcas = Marca::all();
        return view('calzados.create', compact('marcas'));
    }

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

    if ($request->hasFile('imagen')) {
        $validated['imagen'] = $request->file('imagen')->store('calzados', 'public');
    }

    Calzado::create($validated);

    return redirect()->route('calzados.index')->with('success', 'Calzado agregado correctamente.');
}

    public function edit(Calzado $calzado)
    {
        $marcas = Marca::all();
        return view('calzados.edit', compact('calzado', 'marcas'));
    }

    public function update(Request $request, Calzado $calzado)
    {
        $data = $request->all();

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('imagenes', 'public');
        }

        $calzado->update($data);
        return redirect()->route('calzados.index')->with('success', 'Calzado actualizado');
    }

    public function destroy(Calzado $calzado)
    {
        $calzado->delete();
        return redirect()->route('calzados.index')->with('success', 'Calzado eliminado');
    }
}

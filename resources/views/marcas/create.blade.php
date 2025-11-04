@extends('layout')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-3xl font-bold mb-6 bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">Agregar Nueva Marca</h2>

    <form action="{{ route('marcas.store') }}" method="POST" enctype="multipart/form-data" class="bg-gray-800 rounded-xl shadow-2xl p-8 border border-gray-700">
        @csrf
        
        <div class="mb-6">
            <label for="nombre" class="block font-semibold text-gray-200 mb-3 text-lg">Nombre:</label>
            <input type="text" name="nombre" class="w-full p-4 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:bg-gray-650">
        </div>

        <div class="mb-6">
            <label for="pais_origen" class="block font-semibold text-gray-200 mb-3 text-lg">País de origen:</label>
            <input type="text" name="pais_origen" class="w-full p-4 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:bg-gray-650">
        </div>

        <div class="mb-8">
            <label for="logo" class="block font-semibold text-gray-200 mb-3 text-lg">Logo:</label>
            <div class="relative">
                <input type="file" name="logo" class="w-full p-4 bg-gray-700 border-2 border-dashed border-gray-600 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-500 file:text-white hover:file:bg-blue-600 transition-all duration-300 cursor-pointer">
            </div>
            <p class="text-gray-400 text-sm mt-2">Formatos aceptados: JPG, PNG, SVG. Tamaño máximo: 2MB</p>
        </div>

        <button class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold py-4 px-6 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 text-lg">
            Guardar Marca
        </button>
    </form>
</div>
@endsection
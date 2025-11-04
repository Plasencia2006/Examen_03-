@extends('layout')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-3xl font-bold mb-6 bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">Editar Marca</h2>

    <form action="{{ route('marcas.update', $marca) }}" method="POST" enctype="multipart/form-data" class="bg-gray-800 p-8 rounded-xl shadow-2xl border border-gray-700">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label class="block mb-3 font-semibold text-gray-200 text-lg">Nombre:</label>
            <input type="text" name="nombre" value="{{ $marca->nombre }}" class="w-full p-4 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" required>
        </div>

        <div class="mb-6">
            <label class="block mb-3 font-semibold text-gray-200 text-lg">País de Origen:</label>
            <input type="text" name="pais_origen" value="{{ $marca->pais_origen }}" class="w-full p-4 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" required>
        </div>

        <!-- Logo actual -->
        <div class="mb-6">
            <label class="block mb-3 font-semibold text-gray-200 text-lg">Logo Actual:</label>
            <div class="flex items-center space-x-6">
                @if($marca->logo)
                    <div class="relative">
                        <img src="{{ asset('storage/' . $marca->logo) }}" id="currentLogo" class="w-32 h-32 object-contain rounded-lg shadow-lg border-2 border-gray-500 bg-white p-2">
                        <span class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded-full">Actual</span>
                    </div>
                @else
                    <div class="w-32 h-32 bg-gray-700 flex items-center justify-center text-gray-400 text-sm rounded-lg border-2 border-dashed border-gray-600">
                        Sin logo
                    </div>
                @endif
                
                <!-- Flecha indicadora -->
                <div class="text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </div>

                <!-- Vista previa nuevo logo -->
                <div id="preview-container" class="hidden">
                    <div class="relative">
                        <img id="preview" class="w-32 h-32 object-contain rounded-lg shadow-lg border-2 border-green-500 bg-white p-2">
                        <span class="absolute -top-2 -right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">Nuevo</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nuevo logo -->
        <div class="mb-8">
            <label class="block mb-3 font-semibold text-gray-200 text-lg">Nuevo Logo (opcional):</label>
            <div class="flex flex-col items-center justify-center p-6 bg-gray-700 border-2 border-dashed border-gray-600 rounded-xl transition-all duration-300 hover:border-blue-500">
                <div class="text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-400 mb-3">Haz clic para seleccionar un nuevo logo</p>
                    <input type="file" name="logo" class="w-full p-3 bg-gray-600 border border-gray-500 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-500 file:text-white hover:file:bg-green-600 transition-all duration-300 cursor-pointer" accept="image/*" onchange="previewImage(event)">
                </div>
            </div>
        </div>

        <button class="w-full bg-gradient-to-r from-green-600 to-blue-600 text-white font-semibold py-4 px-6 rounded-lg hover:from-green-700 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 text-lg">
            Actualizar Marca
        </button>
    </form>
</div>

<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('preview-container');
    const currentLogo = document.getElementById('currentLogo');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
            if (currentLogo) currentLogo.classList.add('opacity-50');
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '';
        previewContainer.classList.add('hidden');
        if (currentLogo) currentLogo.classList.remove('opacity-50');
    }
}
</script>
@endsection
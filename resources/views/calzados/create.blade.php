@extends('layout.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h2 class="text-3xl font-bold mb-6 bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">Agregar Nuevo Calzado</h2>

    <form action="{{ route('calzados.store') }}" method="POST" enctype="multipart/form-data" class="bg-gray-800 p-8 rounded-xl shadow-2xl border border-gray-700">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            {{-- Modelo --}}
            <div>
                <label class="block mb-3 font-semibold text-gray-200 text-lg">Modelo:</label>
                <input type="text" name="modelo" class="w-full p-4 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" required>
            </div>

            {{-- Talla --}}
            <div>
                <label class="block mb-3 font-semibold text-gray-200 text-lg">Talla:</label>
                <input type="text" name="talla" class="w-full p-4 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            {{-- Color --}}
            <div>
                <label class="block mb-3 font-semibold text-gray-200 text-lg">Color:</label>
                <input type="text" name="color" class="w-full p-4 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" required>
            </div>

            {{-- Precio --}}
            <div>
                <label class="block mb-3 font-semibold text-gray-200 text-lg">Precio:</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">S/</span>
                    <input type="number" step="0.01" name="precio" class="w-full p-4 pl-12 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" required>
                </div>
            </div>
        </div>

        {{-- Marcas con logo --}}
        <div class="mb-8">
            <label class="block font-semibold text-gray-200 mb-4 text-lg">Selecciona una Marca:</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($marcas as $marca)
                    <label class="flex items-center space-x-4 p-4 bg-gray-700 border-2 border-gray-600 rounded-xl cursor-pointer transition-all duration-300 hover:border-blue-500 hover:bg-gray-650 hover:transform hover:-translate-y-1">
                        <input type="radio" name="marca_id" value="{{ $marca->id }}" class="accent-blue-500 transform scale-125" required>
                        
                        @if ($marca->logo)
                            <div class="w-16 h-16 bg-white rounded-lg p-1 shadow-inner">
                                <img src="{{ asset('storage/' . $marca->logo) }}" alt="{{ $marca->nombre }}" class="w-full h-full object-contain">
                            </div>
                        @else
                            <div class="w-16 h-16 bg-gray-600 flex items-center justify-center text-gray-400 text-xs rounded-lg border border-gray-500">
                                Sin logo
                            </div>
                        @endif

                        <span class="font-medium text-white flex-1">{{ $marca->nombre }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Imagen del calzado --}}
        <div class="mb-8">
            <label class="block mb-3 font-semibold text-gray-200 text-lg">Imagen del Calzado:</label>
            <div class="flex flex-col items-center justify-center p-8 bg-gray-700 border-2 border-dashed border-gray-600 rounded-xl transition-all duration-300 hover:border-blue-500">
                <div id="preview-container" class="hidden mb-4">
                    <img id="preview" class="w-48 h-48 object-cover rounded-lg shadow-lg border-2 border-gray-500">
                </div>
                <div class="text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-400 mb-4">Haz clic para seleccionar una imagen</p>
                    <input type="file" name="imagen" class="w-full p-4 bg-gray-600 border border-gray-500 rounded-lg text-white file:mr-4 file:py-3 file:px-6 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-500 file:text-white hover:file:bg-blue-600 transition-all duration-300 cursor-pointer" accept="image/*" onchange="previewImage(event)">
                </div>
            </div>
        </div>

        {{-- Botón guardar --}}
        <button class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold py-4 px-6 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 text-lg">
            Guardar Calzado
        </button>
    </form>
</div>

<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('preview-container');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '';
        previewContainer.classList.add('hidden');
    }
}
</script>

@endsection
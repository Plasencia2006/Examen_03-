@extends('layout.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">Lista de Calzados</h2>
    <a href="{{ route('calzados.create') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1">
        + Nuevo Calzado
    </a>
</div>

<table class="w-full bg-gray-800 rounded-xl shadow-xl overflow-hidden">
    <thead class="bg-gradient-to-r from-gray-700 to-gray-800">
        <tr>
            <th class="px-6 py-4 text-gray-300 font-semibold uppercase tracking-wider text-center">Imagen</th>
            <th class="px-6 py-4 text-gray-300 font-semibold uppercase tracking-wider text-left">Modelo</th>
            <th class="px-6 py-4 text-gray-300 font-semibold uppercase tracking-wider text-center">Talla</th>
            <th class="px-6 py-4 text-gray-300 font-semibold uppercase tracking-wider text-left">Color</th>
            <th class="px-6 py-4 text-gray-300 font-semibold uppercase tracking-wider text-right">Precio</th>
            <th class="px-6 py-4 text-gray-300 font-semibold uppercase tracking-wider text-left">Marca</th>
            <th class="px-6 py-4 text-gray-300 font-semibold uppercase tracking-wider text-center">Acciones</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-700">
        @foreach($calzados as $calzado)
        <tr class="hover:bg-gray-750 transition-colors duration-200">
            <td class="px-6 py-4 text-center">
                @if($calzado->imagen)
                    <div class="w-20 h-20 bg-white rounded-lg p-1 shadow-inner mx-auto">
                        <img src="{{ asset('storage/'.$calzado->imagen) }}" 
                             alt="{{ $calzado->modelo }}" 
                             class="w-full h-full object-cover rounded">
                    </div>
                @else
                    <div class="w-20 h-20 bg-gray-700 flex items-center justify-center text-gray-400 text-sm rounded-lg border border-gray-600 mx-auto">
                        Sin imagen
                    </div>
                @endif
            </td>
            <td class="px-6 py-4 font-medium text-white">{{ $calzado->modelo }}</td>
            <td class="px-6 py-4 text-gray-300 text-center">{{ $calzado->talla }}</td>
            <td class="px-6 py-4 text-gray-300">
                <div class="flex items-center">
                    <div class="w-4 h-4 rounded-full mr-2 border border-gray-500" style="background-color: {{ $calzado->color }}"></div>
                    {{ $calzado->color }}
                </div>
            </td>
            <td class="px-6 py-4 text-green-400 font-semibold text-right">S/ {{ number_format($calzado->precio, 2) }}</td>
            <td class="px-6 py-4">
                <span class="bg-blue-900/30 text-blue-300 px-3 py-1 rounded-full text-sm border border-blue-700/50">
                    {{ $calzado->marca->nombre }}
                </span>
            </td>
            <td class="px-6 py-4">
                <div class="flex space-x-3 justify-center">
                    <a href="{{ route('calzados.edit', $calzado) }}" 
                       class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white px-4 py-2 rounded-lg hover:from-yellow-600 hover:to-yellow-700 transition-all duration-300 shadow hover:shadow-md">
                        Editar
                    </a>
<form id="delete-form-{{ $calzado->id }}" action="{{ route('calzados.destroy', $calzado) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="button"
        onclick="openDeleteModal({{ $calzado->id }})"
        class="bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-2 rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow hover:shadow-md">
        Eliminar
    </button>
</form>

                </div>
            </td>
        </tr>

        
        @endforeach

        
    </tbody>
</table>


<!-- Modal de confirmación (con fondo transparente y efecto blur) -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-900/10 backdrop-blur-sm flex items-center justify-center z-50">
    <div class="bg-white/10 backdrop-blur-md border border-white/20 text-white rounded-2xl p-6 w-80 shadow-2xl transform transition-all scale-100">
        <h2 class="text-xl font-semibold mb-3 text-center text-white">¿Eliminar este calzado?</h2>
        <p class="text-gray-300 text-sm mb-6 text-center">Esta acción no se puede deshacer.</p>
        <div class="flex justify-center gap-4">
            <button id="cancelDelete"
                class="bg-gray-500/40 backdrop-blur-md px-4 py-2 rounded-lg hover:bg-gray-600/50 transition-all">
                Cancelar
            </button>
            <button id="confirmDelete"
                class="bg-gradient-to-r from-red-600 to-red-700 px-4 py-2 rounded-lg hover:from-red-700 hover:to-red-800 transition-all">
                Eliminar
            </button>
        </div>
    </div>
</div>

<script>
    let deleteFormId = null;

    function openDeleteModal(id) {
        deleteFormId = id;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    document.getElementById('cancelDelete').addEventListener('click', () => {
        document.getElementById('deleteModal').classList.add('hidden');
        deleteFormId = null;
    });

    document.getElementById('confirmDelete').addEventListener('click', () => {
        if (deleteFormId) {
            document.getElementById(`delete-form-${deleteFormId}`).submit();
        }
    });
</script>

@endsection

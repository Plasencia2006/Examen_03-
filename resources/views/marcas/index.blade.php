@extends('layout')

@section('content')
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">
    <h2 class="text-3xl font-bold bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
        Lista de Marcas
    </h2>

    <a href="{{ route('marcas.create') }}" 
       class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-lg 
              hover:from-blue-700 hover:to-purple-700 transition-all duration-300 shadow-lg 
              hover:shadow-xl hover:-translate-y-1 text-center">
        + Nueva Marca
    </a>
</div>

{{-- 🔹 Vista tipo tabla (solo visible en pantallas medianas o grandes) --}}
<div class="hidden md:block">
    <table class="w-full bg-gray-800 rounded-xl shadow-xl overflow-hidden">
        <thead class="bg-gradient-to-r from-gray-700 to-gray-800">
            <tr>
                <th class="px-6 py-4 text-gray-300 font-semibold uppercase tracking-wider text-center">Logo</th>
                <th class="px-6 py-4 text-gray-300 font-semibold uppercase tracking-wider text-left">Nombre</th>
                <th class="px-6 py-4 text-gray-300 font-semibold uppercase tracking-wider text-left">País de Origen</th>
                <th class="px-6 py-4 text-gray-300 font-semibold uppercase tracking-wider text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-700">
            @foreach($marcas as $marca)
            <tr class="hover:bg-gray-750 transition-colors duration-200">
                <td class="px-6 py-4 text-center">
                    @if ($marca->logo)
                        <div class="w-16 h-16 bg-white rounded-lg p-1 shadow-inner mx-auto">
                            <img src="{{ asset('storage/' . $marca->logo) }}" 
                                 alt="Logo de {{ $marca->nombre }}" 
                                 class="w-full h-full object-contain">
                        </div>
                    @else
                        <div class="w-16 h-16 bg-gray-700 flex items-center justify-center text-gray-400 text-xs rounded-lg border border-gray-600 mx-auto">
                            Sin logo
                        </div>
                    @endif
                </td>
                <td class="px-6 py-4 font-medium text-white">{{ $marca->nombre }}</td>
                <td class="px-6 py-4 text-gray-300">{{ $marca->pais_origen }}</td>
                <td class="px-6 py-4 text-center">
                    <div class="flex justify-center space-x-3">
                        <a href="{{ route('marcas.edit', $marca) }}" 
                           class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white px-4 py-2 rounded-lg 
                                  hover:from-yellow-600 hover:to-yellow-700 transition-all duration-300 shadow hover:shadow-md">
                            Editar
                        </a>

                        <button type="button" onclick="openDeleteModal({{ $marca->id }})"
                            class="bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-2 rounded-lg 
                                   hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow hover:shadow-md">
                            Eliminar
                        </button>

                        <form id="delete-form-{{ $marca->id }}" action="{{ route('marcas.destroy', $marca) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- 🔹 Vista tipo tarjetas (solo visible en pantallas pequeñas) --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-6 md:hidden">
    @foreach($marcas as $marca)
    <div class="bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-transform transform hover:-translate-y-2">
        {{-- Logo --}}
        <div class="w-full h-48 bg-gray-900 flex items-center justify-center rounded-t-xl overflow-hidden">
            @if ($marca->logo)
                <img src="{{ asset('storage/' . $marca->logo) }}" 
                     alt="Logo de {{ $marca->nombre }}" 
                     class="object-contain w-full h-full p-4">
            @else
                <div class="text-gray-400 text-sm">Sin logo</div>
            @endif
        </div>

        {{-- Info --}}
        <div class="p-5">
            <h3 class="text-xl font-semibold text-white mb-2">{{ $marca->nombre }}</h3>
            <p class="text-gray-400 mb-4"><span class="font-medium text-gray-300">País:</span> {{ $marca->pais_origen }}</p>

            <div class="flex justify-between">
                <a href="{{ route('marcas.edit', $marca) }}" 
                   class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white px-4 py-2 rounded-lg 
                          hover:from-yellow-600 hover:to-yellow-700 transition-all duration-300 shadow hover:shadow-md">
                    Editar
                </a>

                <button type="button" onclick="openDeleteModal({{ $marca->id }})"
                    class="bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-2 rounded-lg 
                           hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow hover:shadow-md">
                    Eliminar
                </button>

                <form id="delete-form-{{ $marca->id }}" action="{{ route('marcas.destroy', $marca) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Si no hay marcas --}}
@if($marcas->isEmpty())
    <div class="text-center text-gray-400 mt-10">
        No hay marcas registradas aún.
    </div>
@endif

{{-- 🔹 Modal personalizado --}}
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-900/10 backdrop-blur-sm flex items-center justify-center z-50 transition-opacity duration-300">
    <div class="bg-white/10 backdrop-blur-md border border-white/20 text-white rounded-2xl p-6 w-80 shadow-2xl transform transition-all scale-100">
        <h2 class="text-xl font-semibold mb-3 text-center text-white">¿Eliminar esta marca?</h2>
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
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        modal.classList.add('opacity-0');
        setTimeout(() => modal.classList.replace('opacity-0', 'opacity-100'), 10);
    }

    document.getElementById('cancelDelete').addEventListener('click', () => {
        const modal = document.getElementById('deleteModal');
        modal.classList.replace('opacity-100', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            deleteFormId = null;
        }, 200);
    });

    document.getElementById('confirmDelete').addEventListener('click', () => {
        if (deleteFormId) {
            document.getElementById(`delete-form-${deleteFormId}`).submit();
        }
    });
</script>
@endsection

@props(['id', 'title'])

<div id="{{ $id }}" class="modal hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg relative p-6">
        <!-- Botón cerrar -->
        <button onclick="cerrarModal('{{ $id }}')" class="absolute top-2 right-2 text-gray-600 hover:text-black text-xl">&times;</button>

        <!-- Título -->
        <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>

        <!-- Contenido dinámico -->
        {{ $slot }}
    </div>
</div>

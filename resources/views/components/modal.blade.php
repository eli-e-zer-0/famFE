@props(['id', 'title'])

<div id="{{ $id }}" class="modal hidden">
    <!-- Fondo oscuro -->
    <div class="modal-overlay" onclick="cerrarModal('{{ $id }}')"></div>

    <!-- Contenido del modal -->
    <div class="modal-content">
        <!-- Botón cerrar (X) en la esquina superior -->
        <button class="modal-close" onclick="cerrarModal('{{ $id }}')" aria-label="Cerrar modal">&times;</button>

        <!-- Título -->
        <h2 class="modal-title">{{ $title }}</h2>

        <!-- Contenido del modal -->
        <div class="modal-body">
            {{ $slot }}
        </div>

        <!-- Botón "Cerrar" fijo en la parte inferior -->
        <div class="flex justify-end mt-6">
            <button type="button" onclick="cerrarModal('{{ $id }}')" class="btn btn-editar">
                Cerrar
            </button>
        </div>
    </div>
</div>

<link href="{{ asset('complement/modal/modal.css') }}" rel="stylesheet">
<script src="{{ asset('complement/modal/modal.js') }}"></script>

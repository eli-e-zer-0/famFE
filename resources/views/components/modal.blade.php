@props(['id', 'title'])

<div id="{{ $id }}" class="modal hidden">
    <div class="modal-overlay" onclick="cerrarModal('{{ $id }}')"></div>
    <div class="modal-content">
        <button class="modal-close" onclick="cerrarModal('{{ $id }}')" aria-label="Cerrar modal">&times;</button>
        <h2 class="modal-title">{{ $title }}</h2>
        <div class="modal-body">
            {{ $slot }}
        </div>
        <div class="flex justify-end mt-6">
            <button type="button" onclick="cerrarModal('{{ $id }}')" class="btn btn-editar">
                Cerrar
            </button>
        </div>
    </div>
</div>

<link href="{{ asset('complement/modal/modal.css') }}" rel="stylesheet">
<script src="{{ asset('complement/modal/modal.js') }}"></script>

{{-- resources/views/components/confirmar-modal.blade.php --}}
<div id="confirmarModal" class="modal-overlay" style="display: none;">
    <div class="modal-content" role="dialog" aria-modal="true" aria-labelledby="modalTitle" aria-describedby="modalDesc">
        <h2 id="modalTitle">Confirmación</h2>
        <p id="modalDesc">¿Estás seguro?</p>

        <div class="modal-buttons">
            <button id="btnNo" type="button">No</button>
            <button id="btnSi" type="button">Sí</button>
        </div>
    </div>
</div>


<link href="{{ asset('complement/confirmar-modal/confirmar-modal.css') }}" rel="stylesheet">

<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Almacenamiento</h1>

    <div class="mb-6">
        <button onclick="abrirModal('almacenamientoModal')" class="btn btn-ver">Agregar</button>
    </div>

    <x-table :headers="$headers" :rows="$rows" />

    <x-modal id="almacenamientoModal" title="Agregar Almacenamiento">
        <form action="{{ route('almacenamiento.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
            </div>

            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required></textarea>
            </div>

            <div class="mb-4">
                <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                <input type="number" name="precio" id="precio" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </x-modal>
</x-app-layout>


<script>
    function abrirModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function cerrarModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    // Opcional: cerrar al hacer clic fuera del contenido
    window.addEventListener('click', function(e) {
        const modales = document.querySelectorAll('.modal');
        modales.forEach(modal => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });
</script>

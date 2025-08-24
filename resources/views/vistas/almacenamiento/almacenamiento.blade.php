<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Almacenamiento</h1>

    <div class="mb-6">
        <button onclick="abrirModal('almacenamientoModal')" class="btn btn-ver">Agregar</button>
    </div>

    <x-table :headers="$headers" :rows="$rows" />

    <x-modal id="almacenamientoModal" title="Agregar Almacenamiento">
        <form id="formAlmacenamiento" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="producto_id" id="producto_id">

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

    <x-confirmar-modal id="modalConfirmacion" title="Confirmar acción" />

</x-app-layout>


<script src="{{ asset('complement/almacenamiento/almacenamiento.js') }}"></script>

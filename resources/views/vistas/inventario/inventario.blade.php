<x-app-layout>
    <div>
        <h1>Inventario</h1>
        <p>Bienvenido a la sección de inventario.</p>

        <!-- Botón para abrir el modal de crear -->
        <button onclick="abrirModal()">Agregar Producto</button>

        <!-- Tabla de inventario -->
        <table id="inventario-table" class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Los datos se insertarán aquí dinámicamente -->
            </tbody>
        </table>
    </div>

    <!-- Modal para crear y editar -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <h2 id="modal-title">Crear Producto</h2>
            <form id="modal-form">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" required></textarea>

                <button type="submit">Guardar</button>
                <button type="button" onclick="cerrarModal()">Cerrar</button>
            </form>
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('complement/inventario/inventario.css') }}">
    <script src="{{ asset('complement/inventario/inventario.js') }}"></script>


</x-app-layout>

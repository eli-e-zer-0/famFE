<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Gestión de Usuarios</h1>

    {{-- Mensajes --}}
    @if (session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    {{-- Botón Agregar --}}
    <button onclick="document.getElementById('modal-agregar').showModal()">Agregar Usuario</button>

    {{-- Tabla --}}
    <table style="width: 100%; margin-top: 1rem; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #2563eb; color: white;">
                <th style="padding: 10px;">Nombre</th>
                <th style="padding: 10px;">Email</th>
                <th style="padding: 10px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr style="border-bottom: 1px solid #ccc;">
                    <td style="padding: 10px;">{{ $user->name }}</td>
                    <td style="padding: 10px;">{{ $user->email }}</td>
                    <td style="padding: 10px;">
                        <button onclick="abrirEditar({{ $user }})">Editar</button>
                        <form method="POST" action="{{ route('admin.usuarios.destroy', $user) }}" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Modal Agregar --}}
    <dialog id="modal-agregar">
        <form method="POST" action="{{ route('admin.usuarios.store') }}">
            @csrf
            <h2>Agregar Usuario</h2>
            <input name="name" placeholder="Nombre" required><br>
            <input name="email" type="email" placeholder="Correo" required><br>
            <input name="password" type="password" placeholder="Contraseña" required><br>
            <button type="submit">Guardar</button>
            <button type="button" onclick="document.getElementById('modal-agregar').close()">Cancelar</button>
        </form>
    </dialog>

    {{-- Modal Editar --}}
    <dialog id="modal-editar">
        <form id="form-editar" method="POST">
            @csrf @method('PUT')
            <h2>Editar Usuario</h2>
            <input id="edit-name" name="name" required><br>
            <input id="edit-email" name="email" type="email" required><br>
            <button type="submit">Actualizar</button>
            <button type="button" onclick="document.getElementById('modal-editar').close()">Cancelar</button>
        </form>
    </dialog>

    <script>
        function abrirEditar(user) {
            const form = document.getElementById('form-editar');
            form.action = `/admin/usuarios/${user.id}`;
            document.getElementById('edit-name').value = user.name;
            document.getElementById('edit-email').value = user.email;
            document.getElementById('modal-editar').showModal();
        }
    </script>
</x-app-layout>

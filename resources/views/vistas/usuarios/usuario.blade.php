<x-app-layout>
<div>

    <h1>Gestión de Usuarios</h1>

    <button onclick="openModal('create')">
        Nuevo Usuario
    </button>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role->nombre ?? 'Sin rol' }}</td>
                <td>
                    <button onclick='openModal("view", @json($user))'>Ver</button>
                    <button onclick='openModal("edit", @json($user))'>Editar</button>
                    <button onclick='openModal("delete", @json($user))'>Eliminar</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="userModal" class="modal hidden" tabindex="-1" aria-hidden="true">
    <div class="modal-content" role="dialog" aria-modal="true" aria-labelledby="modalTitle">

        <button class="modal-close" onclick="closeModal()" aria-label="Cerrar modal">&times;</button>

        <!-- Título del modal -->
        <h2 id="modalTitle" class="modal-title"></h2>

        <!-- Formulario de crear/editar -->
        <form id="userForm" method="POST" action="">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div id="modalContent">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" id="name" name="name" required autocomplete="name" />
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required autocomplete="email" />
                </div>

                <div class="form-group">
                    <label for="role_id">Rol</label>
                    <select id="role_id" name="role_id" required>
                        <option value="">-- Seleccionar Rol --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" id="passwordFields">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" autocomplete="new-password" />
                </div>

                <div class="form-group" id="passwordConfirmFields">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" />
                </div>
            </div>

            <div id="modalButtons" class="modal-buttons">
                <button type="button" class="btn btn-cancel" onclick="closeModal()">Cancelar</button>
                <button type="submit" id="modalSubmitBtn" class="btn btn-green">Guardar</button>
            </div>
        </form>

        <!-- Ver Usuario -->
        <div id="viewContent" class="view-content hidden">
            <p><strong>ID:</strong> <span id="viewId"></span></p>
            <p><strong>Nombre:</strong> <span id="viewName"></span></p>
            <p><strong>Email:</strong> <span id="viewEmail"></span></p>
            <p><strong>Rol:</strong> <span id="viewRole"></span></p>
            <button type="button" class="btn btn-cancel mt-4" onclick="closeModal()">Cerrar</button>
        </div>

        <!-- Eliminar Usuario -->
        <div id="deleteContent" class="delete-content hidden">
            <p>¿Estás seguro que deseas eliminar este usuario?</p>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-buttons">
                    <button type="button" class="btn btn-cancel" onclick="closeModal()">Cancelar</button>
                    <button type="submit" class="btn btn-red">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Incluye CSS y JS --}}
<link rel="stylesheet" href="{{ asset('usuarios/usuario.css') }}">
<script src="{{ asset('usuarios/usuario.js') }}"></script>
</x-app-layout>

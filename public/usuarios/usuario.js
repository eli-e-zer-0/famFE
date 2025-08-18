const modal = document.getElementById('userModal');
const modalTitle = document.getElementById('modalTitle');
const userForm = document.getElementById('userForm');
const formMethodInput = document.getElementById('formMethod');
const modalContent = document.getElementById('modalContent');
const modalButtons = document.getElementById('modalButtons');
const viewContent = document.getElementById('viewContent');
const deleteContent = document.getElementById('deleteContent');
const deleteForm = document.getElementById('deleteForm');

function openModal(type, user = null) {
    userForm.reset();
    formMethodInput.value = 'POST';
    modalTitle.textContent = '';
    userForm.action = '';
    deleteForm.action = '';
    modalContent.classList.remove('hidden');
    modalButtons.classList.remove('hidden');
    viewContent.classList.add('hidden');
    deleteContent.classList.add('hidden');

    if (type === 'create') {
        modalTitle.textContent = 'Crear Nuevo Usuario';
        formMethodInput.value = 'POST';
        userForm.action = '/admin/usuarios/store';
        document.getElementById('password').required = true;
        document.getElementById('password_confirmation').required = true;
    } else if (type === 'edit') {
        modalTitle.textContent = 'Editar Usuario';
        formMethodInput.value = 'PUT';
        userForm.action = `/admin/usuarios/${user.id}`;
        document.getElementById('name').value = user.name;
        document.getElementById('email').value = user.email;
        document.getElementById('role_id').value = user.role_id ?? '';
        document.getElementById('password').required = false;
        document.getElementById('password_confirmation').required = false;
    } else if (type === 'view') {
        modalTitle.textContent = 'Ver Usuario';
        modalContent.classList.add('hidden');
        modalButtons.classList.add('hidden');
        viewContent.classList.remove('hidden');
        document.getElementById('viewId').textContent = user.id;
        document.getElementById('viewName').textContent = user.name;
        document.getElementById('viewEmail').textContent = user.email;
        document.getElementById('viewRole').textContent = user.role?.nombre ?? 'Sin rol';
    } else if (type === 'delete') {
        modalTitle.textContent = 'Eliminar Usuario';
        modalContent.classList.add('hidden');
        modalButtons.classList.add('hidden');
        deleteContent.classList.remove('hidden');
        deleteForm.action = `/admin/usuarios/${user.id}`;
    }

    modal.classList.remove('hidden');
    modal.focus();
}

function closeModal() {
    modal.classList.add('hidden');
}

// Toast de éxito
function showToast(message) {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toastMessage');

    toastMessage.textContent = message;
    toast.classList.remove('toast-hidden');
    toast.classList.add('show');

    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            toast.classList.add('toast-hidden');
        }, 300);
    }, 3000);
}

// Leer usuarios y renderizar tabla
async function fetchUsuarios() {
    try {
        const response = await fetch('/admin/usuarios/listado');
        if (!response.ok) throw new Error('Error al cargar usuarios');

        const data = await response.json();
        const tbody = document.getElementById('usersTableBody');
        tbody.innerHTML = '';

        data.users.forEach(user => {
            const role = data.roles.find(r => r.id === user.role_id);
            const roleName = role ? role.nombre : 'Sin rol';

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${user.id}</td>
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td>${roleName}</td>
                <td>
                    <button onclick='openModal("view", ${JSON.stringify(user)})'>Ver</button>
                    <button onclick='openModal("edit", ${JSON.stringify(user)})'>Editar</button>
                    <button onclick='openModal("delete", ${JSON.stringify(user)})'>Eliminar</button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    } catch (error) {
        console.error(error);
        alert('No se pudo cargar la lista de usuarios.');
    }
}

// Crear o actualizar usuario por AJAX
userForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(userForm);
    const method = formMethodInput.value;
    const action = userForm.action;

    try {
        const response = await fetch(action, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            },
            body: formData,
        });

        const result = await response.json();

        if (!response.ok) {
            console.error(result);
            alert('Error al guardar. Revisa los campos.');
            return;
        }

        showToast(result.message || 'Usuario guardado correctamente');
        closeModal();
        fetchUsuarios();

    } catch (error) {
        console.error('Error al enviar el formulario:', error);
        alert('Ocurrió un error inesperado.');
    }
});

// Eliminar usuario por AJAX
deleteForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const action = deleteForm.action;

    try {
        const response = await fetch(action, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            },
        });

        const result = await response.json();

        if (!response.ok) {
            console.error(result);
            alert('Error al eliminar el usuario.');
            return;
        }

        showToast(result.message || 'Usuario eliminado correctamente');
        closeModal();
        fetchUsuarios();

    } catch (error) {
        console.error('Error al eliminar usuario:', error);
        alert('Ocurrió un error inesperado.');
    }
});

// Cargar roles en el select
function listarRoles() {
    fetch('/admin/roles/listado')
        .then(response => response.json())
        .then(data => {
            const roleSelect = document.getElementById('role_id');
            roleSelect.innerHTML = '<option value="">-- Seleccionar Rol --</option>';

            data.roles.forEach(role => {
                const option = document.createElement('option');
                option.value = role.id;
                option.textContent = role.nombre;
                roleSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error al cargar roles:', error);
        });
}

document.addEventListener('DOMContentLoaded', () => {
    fetchUsuarios();
    listarRoles();
});

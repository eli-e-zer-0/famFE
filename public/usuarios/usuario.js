const modal = document.getElementById('userModal');
const modalTitle = document.getElementById('modalTitle');
const userForm = document.getElementById('userForm');
const formMethodInput = document.getElementById('formMethod');
const modalContent = document.getElementById('modalContent');
const modalButtons = document.getElementById('modalButtons');
const viewContent = document.getElementById('viewContent');
const deleteContent = document.getElementById('deleteContent');
const deleteForm = document.getElementById('deleteForm');

function openModal(type, user=null) {
    // Reset todo
    userForm.reset();
    formMethodInput.value = 'POST';
    modalTitle.textContent = '';
    userForm.action = '';
    deleteForm.action = '';
    modalContent.classList.remove('hidden');
    modalButtons.classList.remove('hidden');
    viewContent.classList.add('hidden');
    deleteContent.classList.add('hidden');

    if(type === 'create') {
        modalTitle.textContent = 'Crear Nuevo Usuario';
        formMethodInput.value = 'POST';
        userForm.action = '/usuarios'; // Cambia según tu ruta POST
        document.getElementById('password').required = true;
        document.getElementById('password_confirmation').required = true;
    }
    else if(type === 'edit') {
        modalTitle.textContent = 'Editar Usuario';
        formMethodInput.value = 'PUT';
        userForm.action = `/usuarios/${user.id}`; // Cambia según ruta PUT
        document.getElementById('name').value = user.name;
        document.getElementById('email').value = user.email;
        document.getElementById('role_id').value = user.role_id ?? '';
        document.getElementById('password').required = false;
        document.getElementById('password_confirmation').required = false;
    }
    else if(type === 'view') {
        modalTitle.textContent = 'Ver Usuario';
        modalContent.classList.add('hidden');
        modalButtons.classList.add('hidden');
        viewContent.classList.remove('hidden');
        document.getElementById('viewId').textContent = user.id;
        document.getElementById('viewName').textContent = user.name;
        document.getElementById('viewEmail').textContent = user.email;
        document.getElementById('viewRole').textContent = user.role?.nombre ?? 'Sin rol';
    }
    else if(type === 'delete') {
        modalTitle.textContent = 'Eliminar Usuario';
        modalContent.classList.add('hidden');
        modalButtons.classList.add('hidden');
        deleteContent.classList.remove('hidden');
        deleteForm.action = `/usuarios/${user.id}`; // Cambia según ruta DELETE
    }

    modal.classList.remove('hidden');
    modal.focus();
}

function closeModal() {
    modal.classList.add('hidden');
}

function abrirModal(id) {
    document.getElementById(id).classList.remove('hidden');
}

function cerrarModal(id) {
    document.getElementById(id).classList.add('hidden');
}

function abrirModalCrear() {
    limpiarFormulario();
    const form = document.getElementById('formAlmacenamiento');
    form.action = "{{ route('almacenamiento.store') }}";
    document.getElementById('formMethod').value = 'POST';

    abrirModal('almacenamientoModal');
}

function abrirModalEditar(datos) {
    limpiarFormulario();

    console.log('aqui vamos a editar');

    console.log(datos);

    // Asignar datos al formulario
    document.getElementById('producto_id').value = datos.producto_id;
    document.getElementById('nombre').value = datos.nombre;
    document.getElementById('descripcion').value = datos.descripcion;
    document.getElementById('precio').value = datos.precio;

    // Cambiar la acción del formulario al update
    const form = document.getElementById('formAlmacenamiento');
    form.action = `/almacenamiento/${datos.producto_id}`;
    document.getElementById('formMethod').value = 'PUT';

    abrirModal('almacenamientoModal');
}

function limpiarFormulario() {
    document.getElementById('formAlmacenamiento').reset();
    document.getElementById('producto_id').value = '';
}

// Asociar evento a botones de editar
document.querySelectorAll('.btn-editar').forEach((btn, index) => {
    btn.addEventListener('click', () => {
        const row = btn.closest('tr').querySelectorAll('td');
        const datos = {
            producto_id: row[1].textContent.trim(), // Asegúrate que sea la posición correcta
            nombre: row[2].textContent.trim(),
            descripcion: row[3].textContent.trim(),
            precio: row[4].textContent.trim()
        };

        abrirModalEditar(datos);
    });
});

// Cambiar botón de agregar
document.querySelector('button[onclick*="abrirModal"]').setAttribute('onclick', 'abrirModalCrear()');

/////////////////////////////////////////////////////////////

document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('confirmarModal');
    const btnNo = document.getElementById('btnNo');
    const btnSi = document.getElementById('btnSi');

    let filaAEliminar = null;

    // Mostrar modal función
    function mostrarModal() {
        modal.style.display = 'flex';
    }

    // Ocultar modal función
    function ocultarModal() {
        modal.style.display = 'none';
    }

    // Evento click en botones eliminar
    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            filaAEliminar = e.target.closest('tr');
            mostrarModal();
        });
    });

    // Click No
    btnNo.addEventListener('click', () => {
        ocultarModal();
        filaAEliminar = null;
    });

    // Click Sí (confirmar)
    btnSi.addEventListener('click', () => {
        if (!filaAEliminar) return;

        const id = filaAEliminar.dataset.id;

        fetch(`/almacenamiento/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        }).then(res => {
            if (res.ok) {
                filaAEliminar.remove();
                alert('Registro eliminado correctamente');
            } else {
                alert('Error al eliminar registro');
            }
            ocultarModal();
            filaAEliminar = null;
        }).catch(() => {
            alert('Error en la conexión');
            ocultarModal();
            filaAEliminar = null;
        });
    });

    // Opcional: cerrar modal al hacer click fuera del contenido
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            ocultarModal();
            filaAEliminar = null;
        }
    });

    // Opcional: cerrar modal con tecla Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === "Escape" && modal.style.display === 'flex') {
            ocultarModal();
            filaAEliminar = null;
        }
    });
});

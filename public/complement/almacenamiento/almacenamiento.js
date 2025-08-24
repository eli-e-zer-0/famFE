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

function limpiarFormulario() {
    document.getElementById('formAlmacenamiento').reset();
    document.getElementById('producto_id').value = '';
}

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

        console.log('Registro eliminado correctamente');
        ocultarModal();
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


/////////////////////////////////////////////////

document.addEventListener('DOMContentLoaded', () => {
    fetchTablaAlmacenamiento();
});

function fetchTablaAlmacenamiento() {
    fetch('/admin/almacenamiento/data')
        .then(res => res.json())
        .then(data => {
            if (data.headers && data.rows) {
                renderTabla(data.headers, data.rows);
            } else {
                document.getElementById('contenedor-tabla').innerHTML = '<p>No hay datos disponibles.</p>';
            }
        })
        .catch(err => {
            console.error('Error al cargar datos de almacenamiento:', err);
            document.getElementById('contenedor-tabla').innerHTML = '<p>Error al cargar la tabla.</p>';
        });
}

function renderTabla(headers, rows) {
    let tablaHTML = '<table class="table-auto w-full border border-gray-300">';
    tablaHTML += '<thead><tr>';

    headers.forEach(header => {
        tablaHTML += `<th class="px-4 py-2 border">${header}</th>`;
    });

    tablaHTML += '</tr></thead><tbody>';

    rows.forEach(row => {
        tablaHTML += '<tr data-id="' + row.id + '">';
        headers.forEach(header => {
            if (header === 'Acciones') {
                tablaHTML += `<td class="px-4 py-2 border text-center">
                    <button class="btn btn-ver btn-editar" data-id="${row.id}">Editar</button>
                    <button class="btn btn-eliminar" data-id="${row.id}">Eliminar</button>
                </td>`;
            } else {
                tablaHTML += `<td class="px-4 py-2 border">${row[header] ?? ''}</td>`;
            }
        });
        tablaHTML += '</tr>';
    });

    tablaHTML += '</tbody></table>';

    document.getElementById('contenedor-tabla').innerHTML = tablaHTML;

    // Reasignar eventos a los botones de eliminar, editar, etc.
    asignarEventosBotones();
}

function asignarEventosBotones() {
    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const id = e.target.dataset.id;
            console.log('Eliminar ID:', id);
            // Aquí puedes abrir el modal de confirmación, etc.
        });
    });

    document.querySelectorAll('.btn-editar').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const id = e.target.dataset.id;
            console.log('Editar ID:', id);
            // Aquí puedes abrir el modal con datos del producto
        });
    });
}


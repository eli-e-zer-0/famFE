let productoIdAEliminar = null;
let filaAEliminar = null;

document.addEventListener('DOMContentLoaded', () => {
    fetchTabla();
});

function fetchTabla() {
    fetch('/admin/almacenamiento/data')
        .then(res => res.json())
        .then(data => {
            renderTabla(data.headers, data.rows);
        })
        .catch(err => console.error('Error al cargar datos:', err));
}

function renderTabla(headers, rows) {
    // Excluir 'id' de los headers para mostrar
    const headersFiltrados = headers.filter(h => h !== 'id');

    let html = '<table class="table-auto w-full border border-gray-300">';
    html += '<thead><tr>';
    headersFiltrados.forEach(header => {
        html += `<th class="border px-4 py-2">${header}</th>`;
    });
    // Columna acciones
    html += `<th class="border px-4 py-2">Acciones</th>`;
    html += '</tr></thead><tbody>';

    rows.forEach(row => {
        html += `<tr data-id="${row.id}">`;
        headersFiltrados.forEach(header => {
            html += `<td class="border px-4 py-2">${row[header]}</td>`;
        });
        // Botón eliminar
        html += `<td class="border px-4 py-2 text-center">
            <button class="btn btn-danger btn-eliminar" data-id="${row.id}">Eliminar</button>
        </td>`;
        html += '</tr>';
    });

    html += '</tbody></table>';

    document.getElementById('contenedor-tabla').innerHTML = html;

    asignarEventosEliminar();
}

function asignarEventosEliminar() {
    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', e => {
            productoIdAEliminar = e.target.dataset.id;
            filaAEliminar = e.target.closest('tr');
            mostrarModalConfirmacion();
        });
    });

    document.getElementById('btnNo').onclick = () => {
        cerrarModalConfirmacion();
    };

    document.getElementById('btnSi').onclick = () => {
        if (!productoIdAEliminar) return;

        fetch(`/almacenamiento/destroy/${productoIdAEliminar}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.message) {
                filaAEliminar.remove();
                cerrarModalConfirmacion();
            } else {
                alert(data.error || 'Error al eliminar');
            }
        })
        .catch(err => {
            console.error('Error al eliminar:', err);
            alert('Error al eliminar');
        });
    };
}

function mostrarModalConfirmacion() {
    document.getElementById('confirmarModal').style.display = 'flex';
}

function cerrarModalConfirmacion() {
    document.getElementById('confirmarModal').style.display = 'none';
    productoIdAEliminar = null;
    filaAEliminar = null;
}

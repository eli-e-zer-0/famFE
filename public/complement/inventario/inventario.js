document.addEventListener('DOMContentLoaded', () => {
    fetchTabla();
});

// Mostrar tabla de inventario
function fetchTabla() {
    console.log('Fetching inventario data...');
    fetch('/admin/inventario/data')
        .then(response => response.json())
        .then(data => {
            renderTabla(data);
        });
}

// Renderizar la tabla con los datos
function renderTabla(data) {
    const tbody = document.querySelector('#inventario-table tbody');
    tbody.innerHTML = ''; // Limpiar la tabla antes de agregar los nuevos datos

    data.forEach(item => {
        const row = document.createElement('tr');
        row.setAttribute('data-id', item.id); // Añadir ID como atributo de la fila
        row.setAttribute('data-nombre', item.nombre); // Añadir nombre como atributo de la fila
        row.setAttribute('data-descripcion', item.descripcion); // Añadir descripción como atributo de la fila

        row.innerHTML = `
            <td>${item.nombre}</td>
            <td>${item.descripcion}</td>
            <td>
                <button class="editar" onclick="abrirModal(${item.id})">
                    <i class="fas fa-edit"></i> Editar
                </button>
                <button class="eliminar" onclick="eliminar(${item.id})">
                    <i class="fas fa-trash-alt"></i> Eliminar
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

// Función para abrir el modal (crear o editar)
function abrirModal(id = null) {
    const modal = document.getElementById('modal');
    const form = document.getElementById('modal-form');
    const title = document.getElementById('modal-title');

    if (id) {
        // Si hay id, encontramos la fila correspondiente
        const row = document.querySelector(`tr[data-id='${id}']`);

        // Extraemos los datos directamente de la fila
        const nombre = row.getAttribute('data-nombre');
        const descripcion = row.getAttribute('data-descripcion');

        // Cargamos los datos en el modal
        document.getElementById('nombre').value = nombre;
        document.getElementById('descripcion').value = descripcion;

        // Cambiar la acción del formulario para actualizar el producto
        form.onsubmit = function(e) {
            e.preventDefault();
            actualizarProducto(id);
        };

        // Cambiar el título del modal para "Editar Producto"
        title.innerText = 'Editar Producto';
        modal.style.display = 'flex'; // Mostrar el modal
    } else {
        // Si no hay id, configuramos el modal para crear un nuevo producto
        form.onsubmit = function(e) {
            e.preventDefault();
            crearProducto();
        };
        document.getElementById('nombre').value = '';
        document.getElementById('descripcion').value = '';
        title.innerText = 'Crear Producto';
        modal.style.display = 'flex'; // Mostrar el modal
    }
}

// Función para cerrar el modal
function cerrarModal() {
    const modal = document.getElementById('modal');
    modal.style.display = 'none'; // Ocultar el modal
}

// Cerrar el modal al hacer clic fuera de él
window.addEventListener('click', function(event) {
    const modal = document.getElementById('modal');
    if (event.target === modal) {
        cerrarModal();
    }
});

// Función para crear un nuevo producto
function crearProducto() {
    const nombre = document.getElementById('nombre').value;
    const descripcion = document.getElementById('descripcion').value;

    fetch('/admin/inventario/crear', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ nombre, descripcion })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Producto creado con éxito');
            fetchTabla(); // Recargar los datos
            cerrarModal(); // Cerrar el modal
        } else {
            alert('Error al crear el producto');
        }
    });
}

// Función para actualizar un producto
function actualizarProducto(id) {
    const nombre = document.getElementById('nombre').value;
    const descripcion = document.getElementById('descripcion').value;

    fetch(`/admin/inventario/actualizar/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ nombre, descripcion })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Producto actualizado con éxito');
            fetchTabla(); // Recargar los datos
            cerrarModal(); // Cerrar el modal
        } else {
            alert('Error al actualizar el producto');
        }
    });
}

// Función para eliminar un producto
function eliminar(id) {
    if (confirm('¿Estás seguro de eliminar este producto?')) {
        fetch(`/admin/inventario/eliminar/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Producto eliminado con éxito');
                fetchTabla(); // Recargar los datos
            } else {
                alert('Error al eliminar el producto');
            }
        });
    }
}

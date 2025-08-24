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

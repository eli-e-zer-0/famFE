document.addEventListener('DOMContentLoaded', function () {
    const filas = Array.from(document.querySelectorAll('#tablaBody tr')); // Todas las filas

    // Filtro de búsqueda
    const input = document.getElementById('filtroInput');
    input.addEventListener('keyup', function () {
        const filtro = input.value.toLowerCase();

        // Filtrar filas
        filas.forEach(fila => {
            let textoFila = '';
            fila.querySelectorAll('td').forEach(celda => {
                textoFila += celda.textContent.toLowerCase() + ' ';
            });
            const mostrar = textoFila.indexOf(filtro) > -1;
            fila.style.display = mostrar ? '' : 'none'; // Ocultar filas que no coinciden
        });
    });
});

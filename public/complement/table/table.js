document.addEventListener('DOMContentLoaded', function () {
    const filas = Array.from(document.querySelectorAll('#tablaBody tr')); // Todas las filas
    let direccionOrden = 1; // 1 ascendente, -1 descendente

    // Función para ordenar las filas
    function ordenarFilas(index) {
        // Filas visibles para ordenar
        let filasArray = Array.from(filas).filter(fila => fila.style.display !== 'none');

        filasArray.sort((a, b) => {
            let celdaA = a.getElementsByTagName('td')[index].textContent.trim();
            let celdaB = b.getElementsByTagName('td')[index].textContent.trim();

            // Intentar comparar números primero
            let numA = parseFloat(celdaA.replace(/[^0-9.-]+/g, ""));
            let numB = parseFloat(celdaB.replace(/[^0-9.-]+/g, ""));

            if (!isNaN(numA) && !isNaN(numB)) {
                return (numA - numB) * direccionOrden;
            } else {
                // Comparar como texto
                return celdaA.localeCompare(celdaB) * direccionOrden;
            }
        });

        // Reagrupar filas ordenadas en tbody
        filasArray.forEach(fila => document.getElementById('tablaBody').appendChild(fila));

        // Cambiar la dirección del orden para la siguiente vez
        direccionOrden = direccionOrden === 1 ? -1 : 1;
    }

    // Ordenar por clic en los encabezados
    const headers = document.querySelectorAll('thead th.sortable');
    headers.forEach((header, index) => {
        header.style.cursor = 'pointer';
        header.addEventListener('click', () => {
            ordenarFilas(index); // Ordenar filas por la columna clickeada
        });
    });

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

        // Restaurar el orden después de filtrar
        direccionOrden = 1; // Reiniciar la dirección para ordenar ascendente después del filtro
    });
});

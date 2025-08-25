<div class="filtro-busqueda" style="margin-bottom: 1rem;">
    <input type="text" id="filtroInput" placeholder="Buscar..." aria-label="Buscar en la tabla" aria-live="polite" style="padding: 0.5rem; width: 100%; max-width: 300px;">
</div>

<div class="tabla-contenedor">
    <table class="tabla-principal" id="tablaAlmacenamiento">
        <thead class="tabla-encabezado">
            <tr>
                @foreach($headers as $header)
                    @if($header !== 'producto_id')
                        <th scope="col" class="th-estilo sortable">
                            {{ $header }}
                        </th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody class="tabla-cuerpo" id="tablaBody">
            @foreach($rows as $index => $row)
                <tr data-id="{{ $row['id'] ?? '' }}" class="{{ $index % 2 == 0 ? 'fila-par' : 'fila-impar' }}">
                    @foreach($row as $key => $cell)
                        <td class="td-estilo {{ $key === 'producto_id' ? 'hidden' : '' }}">
                            {{ $cell }}
                        </td>
                    @endforeach
                    <td>
                        <button class="btn-agregar">
                            <i class="fas fa-shopping-cart"></i> Agregar
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Paginación -->
<div class="paginacion">
    <button id="prevBtn" class="btn-paginacion" disabled>Anterior</button>
    <span id="pageNumber" class="page-number">1</span>
    <button id="nextBtn" class="btn-paginacion">Siguiente</button>
</div>

<link href="{{ asset('complement/table/table.css') }}" rel="stylesheet">
<script src="{{ asset('complement/table/table.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const filasPorPagina = 5; // Cantidad de filas por página
    const filas = Array.from(document.querySelectorAll('#tablaBody tr')); // Todas las filas
    let paginaActual = 1;

    // Función para mostrar las filas según la página actual
    function mostrarFilas(pagina) {
        const filasVisibles = filas.filter(fila => fila.style.display !== 'none'); // Solo las filas visibles después del filtro
        const totalFilas = filasVisibles.length; // Total de filas visibles
        const totalPaginas = Math.ceil(totalFilas / filasPorPagina);

        // Calcular las filas a mostrar para la página actual
        const inicio = (pagina - 1) * filasPorPagina;
        const fin = pagina * filasPorPagina;

        // Ocultar todas las filas
        filas.forEach(fila => fila.style.display = 'none');

        // Mostrar solo las filas visibles que pertenecen a la página actual
        filasVisibles.slice(inicio, fin).forEach(fila => fila.style.display = '');

        // Actualizar el número de página
        document.getElementById('pageNumber').textContent = pagina;

        // Deshabilitar o habilitar los botones de paginación
        document.getElementById('prevBtn').disabled = pagina === 1;
        document.getElementById('nextBtn').disabled = pagina === totalPaginas;
    }

    // Función para mostrar la siguiente página
    function siguientePagina() {
        const filasVisibles = filas.filter(fila => fila.style.display !== 'none');
        const totalFilas = filasVisibles.length;
        const totalPaginas = Math.ceil(totalFilas / filasPorPagina);

        if (paginaActual < totalPaginas) {
            paginaActual++;
            mostrarFilas(paginaActual);
        }
    }

    // Función para mostrar la página anterior
    function paginaAnterior() {
        if (paginaActual > 1) {
            paginaActual--;
            mostrarFilas(paginaActual);
        }
    }

    // Botón anterior
    document.getElementById('prevBtn').addEventListener('click', paginaAnterior);

    // Botón siguiente
    document.getElementById('nextBtn').addEventListener('click', siguientePagina);

    // Mostrar las filas para la primera página
    mostrarFilas(paginaActual);

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

        // Resetear la paginación después de aplicar el filtro
        paginaActual = 1; // Reiniciar la página al inicio
        mostrarFilas(paginaActual); // Actualizar la vista
    });

    // Ordenamiento al hacer clic en encabezados
    const headers = document.querySelectorAll('thead th.sortable');
    let direccionOrden = 1; // 1 ascendente, -1 descendente

    headers.forEach((header, index) => {
        header.style.cursor = 'pointer';
        header.addEventListener('click', () => {
            // Toggle dirección
            direccionOrden = (header.dataset.orden === 'asc') ? -1 : 1;
            // Remover indicadores de otros encabezados
            headers.forEach(h => h.dataset.orden = '');
            header.dataset.orden = direccionOrden === 1 ? 'asc' : 'desc';

            // Obtener todas las filas visibles para ordenar
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

            // Reajustar la paginación después de ordenar
            mostrarFilas(paginaActual);
        });
    });
});
</script>

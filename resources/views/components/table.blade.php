<div class="filtro-busqueda" style="margin-bottom: 1rem;">
    <input type="text" id="filtroInput" placeholder="Buscar..." style="padding: 0.5rem; width: 100%; max-width: 300px;">
</div>

<div class="tabla-contenedor">
    <table class="tabla-principal" id="tablaAlmacenamiento">
        <!-- Encabezado -->
        <thead class="tabla-encabezado">
            <tr>
                @foreach($headers as $header)
                    <th scope="col" class="th-estilo sortable">
                        {{ $header }}
                    </th>
                @endforeach
                <!-- <th scope="col" class="th-estilo th-acciones">
                    Acciones
                </th> -->
            </tr>
        </thead>

        <!-- Cuerpo con filas alternadas -->
        <tbody class="tabla-cuerpo">
            @forelse($rows as $index => $row)
                <tr class="{{ $index % 2 == 0 ? 'fila-par' : 'fila-impar' }}">
                    @foreach($row as $cell)
                        <td class="td-estilo">
                            {{ $cell }}
                        </td>
                    @endforeach
                    <!-- <td class="td-estilo td-acciones">
                        <button class="btn btn-ver">Ver</button>
                        <button class="btn btn-editar">Editar</button>
                        <button class="btn btn-eliminar">Eliminar</button>
                    </td> -->
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) + 1 }}" class="td-vacio">
                        No hay registros disponibles.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Script para filtro y ordenamiento -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('filtroInput');
    const tabla = document.getElementById('tablaAlmacenamiento');
    const tbody = tabla.querySelector('tbody');
    const filas = tbody.getElementsByTagName('tr');

    // Filtro por texto
    input.addEventListener('keyup', function () {
        const filtro = input.value.toLowerCase();

        for (let fila of filas) {
            let textoFila = '';
            for (let celda of fila.getElementsByTagName('td')) {
                textoFila += celda.textContent.toLowerCase() + ' ';
            }
            fila.style.display = textoFila.indexOf(filtro) > -1 ? '' : 'none';
        }
    });

    // Ordenamiento al hacer clic en encabezados
    const headers = tabla.querySelectorAll('thead th.sortable');
    let direccionOrden = 1; // 1 ascendente, -1 descendente

    headers.forEach((header, index) => {
        header.style.cursor = 'pointer';
        header.addEventListener('click', () => {
            // Toggle dirección
            direccionOrden = (header.dataset.orden === 'asc') ? -1 : 1;
            // Remover indicadores de otros encabezados
            headers.forEach(h => h.dataset.orden = '');
            header.dataset.orden = direccionOrden === 1 ? 'asc' : 'desc';

            // Obtener todas las filas en array para ordenar
            let filasArray = Array.from(filas).filter(fila => fila.style.display !== 'none');

            filasArray.sort((a, b) => {
                // Obtener texto de la celda en la columna index
                let celdaA = a.getElementsByTagName('td')[index].textContent.trim();
                let celdaB = b.getElementsByTagName('td')[index].textContent.trim();

                // Intentar comparar números primero
                let numA = parseFloat(celdaA.replace(/[^0-9.-]+/g,"")); // quitar símbolos no numéricos
                let numB = parseFloat(celdaB.replace(/[^0-9.-]+/g,""));

                if (!isNaN(numA) && !isNaN(numB)) {
                    return (numA - numB) * direccionOrden;
                } else {
                    // Comparar como texto
                    return celdaA.localeCompare(celdaB) * direccionOrden;
                }
            });

            // Reagrupar filas ordenadas en tbody
            filasArray.forEach(fila => tbody.appendChild(fila));
        });
    });
});
</script>

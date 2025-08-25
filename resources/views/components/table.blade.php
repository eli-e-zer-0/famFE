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

<!-- asdf -->
<link href="{{ asset('complement/table/table.css') }}" rel="stylesheet">
<script src="{{ asset('complement/table/table.js') }}"></script>

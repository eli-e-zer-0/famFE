<div class="filtro-busqueda" style="margin-bottom: 1rem;">
    <input type="text" id="filtroInput" placeholder="Buscar..." style="padding: 0.5rem; width: 100%; max-width: 300px;">
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
                <th scope="col" class="th-estilo th-acciones">
                    Acciones
                </th>
            </tr>
        </thead>
        <tbody class="tabla-cuerpo">
            @forelse($rows as $index => $row)
            <tr class="{{ $index % 2 == 0 ? 'fila-par' : 'fila-impar' }}">
                @foreach($row as $key => $cell)
                <td class="td-estilo {{ $key === 'producto_id' ? 'hidden' : '' }}">
                    {{ $cell }}
                </td>
                @endforeach
                <td class="td-estilo td-acciones">
                    <button class="btn btn-editar">Editar</button>
                    <button class="btn btn-eliminar">Eliminar</button>
                </td>
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

<link href="{{ asset('complement/table/table.css') }}" rel="stylesheet">
<script src="{{ asset('complement/table/table.js') }}"></script>

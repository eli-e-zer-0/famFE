<div class="overflow-x-auto">
    <table class="min-w-full border border-gray-200 rounded-lg shadow-md">
        <thead class="bg-gray-100">
            <tr>
                @foreach($headers as $header)
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 border-b">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white">
            @forelse($rows as $row)
                <tr class="hover:bg-gray-50">
                    @foreach($row as $cell)
                        <td class="px-4 py-2 text-sm text-gray-600 border-b">
                            {{ $cell }}
                        </td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) }}" class="px-4 py-3 text-center text-gray-500">
                        No hay registros disponibles.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


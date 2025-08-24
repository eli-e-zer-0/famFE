<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Almacenamiento</h1>

    <div id="contenedor-tabla" class="mt-6"></div>

    {{-- Modal de confirmación --}}
    <x-confirmar-modal />

    {{-- CSRF Token en el head --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Scripts y estilos --}}
    <link href="{{ asset('complement/confirmar-modal/confirmar-modal.css') }}" rel="stylesheet">
    <script src="{{ asset('complement/almacenamiento/almacenamiento.js') }}"></script>
</x-app-layout>

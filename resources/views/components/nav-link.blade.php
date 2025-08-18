@props(['active' => false])

<style>
    .nav-link {
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 0.375rem;
        transition: background-color 0.3s;
        text-decoration: none;
        color: #023e8a;
        background-color: transparent;
    }

    .nav-link:hover {
        background-color: #caf0f8;
    }

    .nav-link.active {
        background-color: #0077b6;
        color: white;
    }
</style>

@php
    $classes = $active ? 'nav-link active' : 'nav-link';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

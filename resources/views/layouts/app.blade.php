<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            background-color: #f4f9fb; /* azul muy claro */
            color: #1a202c;
        }

        header {
            background-color: #0077b6; /* azul cielo */
            color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
        }

        .logo-toggle-wrapper {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: white;
            font-weight: 600;
            font-size: 1.125rem;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            cursor: pointer;
            color: white;
            font-size: 1.5rem;
            padding: 0.25rem;
        }

        .app-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            display: flex;
            flex: 1;
            overflow: hidden;
            height: calc(100vh - 64px);
        }

        main.content {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem;
            transition: margin-left 0.3s ease;
        }

        @media (max-width: 768px) {
            main.content {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body x-data="{ sidebarOpen: window.innerWidth >= 768 }" @resize.window="sidebarOpen = window.innerWidth >= 768">

<div class="app-container">
    <header>
        <div class="logo-toggle-wrapper">
            <a href="{{ route('dashboard') }}" class="logo-container">
                <x-application-logo style="height: 32px; width: auto;" />
                <span>{{ config('app.name', 'Laravel') }}</span>
            </a>
            <button class="sidebar-toggle" @click="sidebarOpen = !sidebarOpen">
                <template x-if="sidebarOpen">
                    <svg xmlns="http://www.w3.org/2000/svg" style="height: 24px; width: 24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </template>
                <template x-if="!sidebarOpen">
                    <svg xmlns="http://www.w3.org/2000/svg" style="height: 24px; width: 24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </template>
            </button>
        </div>
    </header>

    <div class="container">
        @include('layouts.navigation', ['sidebarOpen' => 'sidebarOpen'])

        <main
            class="content"
            :style="sidebarOpen && window.innerWidth >= 768 ? 'margin-left: 16rem;' : 'margin-left: 0;'"
        >
            {{ $slot }}
        </main>
    </div>
</div>

</body>
</html>

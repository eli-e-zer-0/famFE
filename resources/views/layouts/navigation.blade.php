@props(['sidebarOpen'])

<style>
    aside {
        background-color: #e9f5ff;
        border-right: 2px solid #0077b6;
        transition: width 0.3s ease-in-out;
        overflow: hidden;
        height: calc(100vh - 64px);
        display: flex;
        flex-direction: column;
        position: fixed;
        top: 64px;
        left: 0;
        z-index: 9;
    }

    aside.closed {
        width: 0;
    }

    aside.open {
        width: 16rem;
    }

    nav {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .user-info {
        border-top: 2px solid #caf0f8;
        background-color: #d4f1ff;
        padding: 1rem;
        font-size: 0.875rem;
        color: #023e8a;
    }

    .user-name {
        font-weight: 600;
        color: #0077b6;
    }

    .logout-form a {
        cursor: pointer;
        color: #d00000;
        text-decoration: underline;
        font-weight: 600;
        display: inline-block;
        margin-top: 0.5rem;
    }

    @media (max-width: 768px) {
        aside {
            position: absolute;
        }
    }
</style>

<aside :class="sidebarOpen ? 'open' : 'closed'">
    <nav x-show="sidebarOpen" x-transition>
        <x-nav-link :href="route('almacenamiento')" :active="request()->routeIs('almacenamiento')">
            Almacenamiento
        </x-nav-link>
        <nav class="flex-1 overflow-y-auto py-4 px-2 space-y-2">
    @foreach ($menuOptions as $option)
        <x-nav-link :href="route($option->ruta)" :active="request()->routeIs($option->ruta)">
            <span class="ml-2">{{ $option->opcion }}</span>
        </x-nav-link>
    @endforeach
</nav>

    </nav>

    <div class="user-info" x-show="sidebarOpen" x-transition>
        <div class="user-name">{{ Auth::user()->name }}</div>
        <div>{{ Auth::user()->email }}</div>

        <div class="logout-form">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                    Cerrar sesión
                </x-nav-link>
            </form>
        </div>
    </div>
</aside>

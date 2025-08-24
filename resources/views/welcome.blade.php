<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Fam Fe y Esperanza</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <style>
            body {
                font-family: 'Figtree', sans-serif;
                margin: 0;
                padding: 0;
                height: 100vh;
                background-image: url('https://cdn.pixabay.com/photo/2017/01/11/10/19/guatemala-1971376_1280.jpg');
                background-size: cover;
                background-position: center;
                color: #FFF;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .card {
                background: rgba(0, 0, 0, 0.7); /* Fondo más oscuro para mejorar la legibilidad */
                padding: 30px 40px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); /* Sombra más pronunciada */
                text-align: center;
                max-width: 400px;
                width: 100%;
                border: 2px solid #1e3a8a; /* Borde azul de la bandera */
            }

            .card h1 {
                font-size: 2.5rem;
                margin-bottom: 20px;
                color: #FFD700; /* Amarillo para el título */
            }

            .card .text-secondary {
                font-size: 1.2rem;
                color: #3b82f6; /* Azul claro de la bandera */
                margin-bottom: 30px;
            }

            .card .button {
                background-color: #1e3a8a; /* Azul de la bandera */
                color: #FFF;
                padding: 10px 20px;
                border-radius: 5px;
                text-decoration: none;
                font-weight: bold;
                margin-top: 10px;
                display: inline-block;
            }

            .card .button:hover {
                background-color: #2563eb; /* Azul más oscuro */
            }

            .card .login-links {
                margin-top: 20px;
            }

            .card .login-links a {
                color: #FFD700; /* Amarillo */
                font-weight: bold;
                text-decoration: none;
                margin-left: 10px;
            }

            .card .login-links a:hover {
                color: #F9A825; /* Amarillo más oscuro */
            }
        </style>
    </head>
    <body>
        <div class="card">
            <h1>Familia Fe y Esperanza</h1>

            <div class="login-links">
                @if (Route::has('login'))
                    <div>
                        @auth
                            <a href="{{ url('/dashboard') }}" class="button">Ir a Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="button">Iniciar Sesión</a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </body>
</html>

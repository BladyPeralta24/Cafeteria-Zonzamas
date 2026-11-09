<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') · Cafetería Zonzamas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body>
<header>
    <nav class="navbar navbar-light custom-navbar">
        <div class="container-fluid d-flex flex-wrap align-items-center justify-content-between gap-2">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img class="img-fluid img-logo" src="{{ asset('img/icono_zonzamas.png') }}" alt="Icono Zonzamas" />
            </a>

            <div class="d-flex flex-wrap align-items-center gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-pill">Ir a la carta</a>
                    <a href="{{ route('cart.index') }}" class="btn-pill">Mi reserva</a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn-pill btn-pill-button">Cerrar sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-pill">
                        <img class="icono-usuario" src="{{ asset('img/usuario.png') }}" alt=""> Iniciar sesión
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-pill">Registrarse</a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>
</header>

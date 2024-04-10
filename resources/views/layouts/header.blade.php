<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield("title")</title>

    <!-- Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('css/style.css')}}" />
</head>
<body>
<header>
    <nav class="navbar navbar-light custom-navbar" style="background-color: rgb(221, 184, 106);">
        <div class="container-fluid row">
            @if (Route::has('login'))
                <a class="navbar-brand col" href="#"><img class="img-fluid img-logo" src="{{asset('img/icono_zonzamas.png')}}" alt="Icono Zonzamas" /></a>
                @auth
                    @else
                        <a href="{{ route('login') }}" class="log-in col col-md-auto"><img src="{{asset('img/usuario.png')}}" alt="icono usuario"> Iniciar sesión</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="register col col-lg-1">Registrarse</a>
                        @endif
                @endauth
            @endif
        </div>
    </nav>
</header>

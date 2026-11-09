@extends('layouts.layout')

@section('title', 'Página principal')

@section('content')
        <section class="one">
            <video
                autoplay
                loop
                muted
                playsinline
                src="{{ asset('img/vid/grano-cafe.mp4') }}"
            ></video>
            <div class="one-texto">
                <h1>Cafetería <br> CIFP Zonzamas</h1>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-pill btn-grande">Ver la carta</a>
                @else
                    <a href="{{ route('register') }}" class="btn-pill btn-grande">Empieza a reservar</a>
                @endauth
            </div>
        </section>

        <section class="second">
            <div class="second-texto">
                <h1>Servicio de reserva</h1>
                <p>
                    En esta plataforma puedes hacer reserva de cualquier producto de
                    la cafetería al alcance de tu mano, ahorrándote largas colas.
                </p>
            </div>
            <div class="second-imagenes">
                <img class="sandwich" src="{{ asset('img/fotos/sandwich.png') }}" alt="sandwich">
                <img class="cafe" src="{{ asset('img/fotos/cafe.png') }}" alt="café">
            </div>
        </section>

        <section class="third">
            <div class="box-container">
                <div class="box">
                    <div class="text-box">
                        <h2>Elige</h2>
                        <p>
                            Elige el producto a través de la carta de la cafetería,
                            con sus precios marcados.
                        </p>
                    </div>
                    <img class="img-elegir" src="{{ asset('img/elegir.png') }}" alt="elegir">
                </div>
                <div class="box">
                    <div class="text-box">
                        <h2>Reserva</h2>
                        <p>
                            Reserva el producto que deseas, indicando la hora
                            a la que quieres recogerlo.
                        </p>
                    </div>
                    <img class="img-reservar" src="{{ asset('img/reserva.png') }}" alt="reservar">
                </div>
                <div class="box">
                    <div class="text-box">
                        <h2>Recoge</h2>
                        <p>
                            Recoge tu producto a la hora indicada, sin tener
                            que esperar colas.
                        </p>
                    </div>
                    <img class="img-recoger" src="{{ asset('img/recoger.png') }}" alt="recoger">
                </div>
            </div>
        </section>
@endsection

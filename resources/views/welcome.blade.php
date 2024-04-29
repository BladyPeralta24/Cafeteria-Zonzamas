@extends('layouts.layout')

@section('title', 'Página principal')

@section('content')
        <section class="one">
            <h1>Cafetería <br>
                CIFP Zonzamas
            </h1>
            <video
            loop
            oncanplay="this.play()"
            onloadedmetadata="this.muted = true"
            src="{{asset('img/vid/grano-cafe.mp4')}}"
            ></video>
        </section>
        <section class="second">
            <h1>Servicio de reserva</h1>
            <p>En esta plataforma puedes hacer <br>
                reserva de cualquier producto de <br>
                la cafetería al alcance de tu mano, <br>
                ahorrandote largas colas
            </p>
            <div class="imagene1">
                <img class="sandwich" src="{{asset('img/fotos/sandwich.png')}}" alt="sandwich">
                <img class="cafe" src="{{asset('img/fotos/cafe.png')}}" alt="cafe">
            </div>
        </section>
        <section class="third">
            <div class="box-container">
                <div class="box">
                    <div class="text-box">
                        <h1>Elige</h1><br>
                        <p>
                            Elige el producto a traves del menu de la cafeteria,
                            con sus precios marcados.
                        </p>
                    </div>
                    <img class="img-elegir" src="{{asset('img/elegir.png')}}" alt="elegir">
                </div>
                <div class="box">
                    <div class="text-box">
                        <h1>Reserva</h1><br>
                        <p>
                            Reserva el producto que deseas, indicando la hora
                            a la que deseas recogerlo.
                        </p>
                    </div>
                    <img class="img-reservar" src="{{asset('img/reserva.png')}}" alt="reservar">
                </div>
                <div class="box">
                    <div class="text-box">
                        <h1>Recoge</h1><br>
                        <p>
                            Recoge tu producto en la hora indicada, sin tener
                            que esperar colas.
                        </p>
                    </div>
                    <img class="img-recoger" src="{{asset('img/recoger.png')}}" alt="recoger">
            </div>
        </section>
        <section class="fourth">
            Cuarta sección
        </section>

@endsection

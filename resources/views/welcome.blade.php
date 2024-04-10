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
            Tercera sección
        </section>
        <section class="fourth">
            Cuarta sección
        </section>
@endsection

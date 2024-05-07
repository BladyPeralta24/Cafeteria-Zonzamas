<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-black-200 dark:text-gray-800 leading-tight">
            {{__('Cafeteria CIFP Zonzamas')}}
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 align-center">
            <div class="bg-gray-800 dark:bg-dark overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white text-center font-bold text-4xl">
                    {{ __("Carta del Día") }}
                </div>
                <br/>
                @foreach ($categorias as $categoria)
                    <h2 class="text-center text-4xl font-bold bg-white p-3 rounded-md mx-auto w-1/2">{{ $categoria->nombre }}</h2>
                    <div class="flex flex-wrap justify-around">
                        @foreach ($categoria->productos as $producto)
                            <div class="card bg-white rounded-lg shadow-md custom-card m-4 w-full sm:w-1/2 md:w-1/3 lg:w-1/2 xl:w-1/5">
                                <button class="btn btn-primary view-details" data-toggle="modal" data-target="#productModal" data-name="{{ $producto->nombre }}" data-description="{{ $producto->descripcion }}" data-price="{{ $producto->precio_unitario }}" data-image="{{ asset($producto->imagen) }}">
                                    <div class="card-body p-6">
                                        <h5 class="card-title text-lg font-semibold text-black">{{ $producto->nombre }}</h5>
                                        <p class="card-text text-gray-600">{{$producto->precio_unitario }} €</p>
                                        <img src="{{ asset($producto->imagen) }}" alt="imagen" class="w-20 h-20">
                                        Ver Detalles
                                    </div>
                                </button>
                            </div>
                            @endforeach
                            @include('components.modal', ['producto' => $producto, 'id' => 'modal-' . $producto->id_producto])
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <footer>
        <div class="text-center p-4 bg-gray-800 text-white">
            © 2024 CIFP Zonzamas:
            <a class="text-reset fw-bold" href="https://cifpzonzamas.es/" target="_blank">www.cifpzonzamas.es</a>
        </div>
    </footer>

    <style>
        .custom-card {
            /* Aquí puedes agregar tus estilos personalizados */
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .custom-card:hover {
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        .card-container {
            height: 900px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        .card{
            width: 150px;
            height: 210px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            transition: all 0.3s ease;

        }

        .card-body{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .modal{
            display: none;
        }
    </style>

</x-app-layout>

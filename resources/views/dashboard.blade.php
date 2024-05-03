<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-black-200 dark:text-gray-800 leading-tight">
            {{__('Cafeteria CIFP Zonzamas')}}
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 align-center">
            <div class="bg-gray-800 dark:bg-dark overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    {{ __("Carta del Día") }}
                </div>
                <br/>
                @foreach ($categorias as $categoria)
                <h2 class="text-center text-4xl font-bold bg-white p-3 rounded-md mx-auto w-1/2">{{ $categoria->nombre }}</h2>
                    @foreach ($categoria->productos as $producto)
                        <div class="card bg-white rounded-lg shadow-md custom-card m-4">
                            <div class="card-body p-6">
                                <h5 class="card-title text-lg font-semibold text-black">{{ $producto->nombre }}</h5>
                                <p class="card-text text-gray-600">{{$producto->precio_unitario }} €</p>
                            </div>
                        </div>
                    @endforeach
                @endforeach
                {{-- <div class="card-container justify-center gap-4 p-4 flex flex-col">
                    @foreach ($productos as $producto)
                        <div class="card bg-white rounded-lg shadow-md custom-card m-4">
                            <div class="card-body p-6">
                                <h5 class="card-title text-lg font-semibold text-black">{{ $producto->nombre }}</h5>
                                <p class="card-text text-gray-600">{{$producto->precio_unitario }} €</p>
                                <p class="card-category text-gray-600">{{$producto->categoria ? $producto->categoria->nombre : 'Sin categoría' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div> --}}

            </div>
        </div>
    </div>

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
            height: 150px;
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
    </style>
</x-app-layout>

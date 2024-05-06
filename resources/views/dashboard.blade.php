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
                    <div class="flex flex-wrap justify-around">
                        @foreach ($categoria->productos as $producto)
                            <div class="card bg-white rounded-lg shadow-md custom-card m-4 w-full sm:w-1/2 md:w-1/3 lg:w-1/2 xl:w-1/5">
                                <div class="card-body p-6">
                                    <h5 class="card-title text-lg font-semibold text-black">{{ $producto->nombre }}</h5>
                                    <p class="card-text text-gray-600">{{$producto->precio_unitario }} €</p>
                                    <img src="{{ asset($producto->imagen) }}" alt="imagen" class="w-20 h-20">
                                    <button class="open-modal" data-id="{{ $producto->id }}">Ver detalles</button>
                                </div>
                            </div>
                        @endforeach

                        {{-- Aquí es donde irá el modal --}}
                        <div id="modal" style="display: none;">
                            <div id="modal-content">
                                {{-- Detalles del producto se cargará aquí --}}
                            </div>
                            <button id="close-modal">Cerrar</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    <script>
        // Para el manejo de los modales en el archivo dashboard.blade.php
        document.addEventListener('DOMContentLoaded', function() {
            // Encuentra todos los botones que abren el modal
            var openModalButtons = document.querySelectorAll('.open-modal');

            // Añade un evento click a cada botón
            openModalButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    // Obtiene el ID del producto del atributo data-id del botón
                    var id = button.getAttribute('data-id');

                    // Abre el modal
                    var modal = document.getElementById('modal');
                    modal.style.display = 'block';

                    // Carga los detalles del producto en el modal
                    var modalContent = document.getElementById('modal-content');
                    fetch('/producto/' + id)
                        .then(function(response) { return response.text(); })
                        .then(function(html) { modalContent.innerHTML = html; });
                });
            });

            // Encuentra el botón que cierra el modal
            var closeModalButton = document.getElementById('close-modal');

            // Añade un evento click al botón
            closeModalButton.addEventListener('click', function() {
                // Cierra el modal
                var modal = document.getElementById('modal');
                modal.style.display = 'none';
            });
        });

    </script>
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
            height: 200px;
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

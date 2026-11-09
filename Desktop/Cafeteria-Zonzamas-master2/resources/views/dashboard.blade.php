<x-app-layout>
    <x-slot name="title">Carta · Cafetería Zonzamas</x-slot>

    <x-slot name="header">
        <h1 class="font-semibold text-2xl text-gray-800 leading-tight">
            Carta del día
        </h1>
        <p class="text-gray-600 text-sm mt-1">
            Elige lo que quieras, añádelo a tu reserva e indica a qué hora lo recoges.
        </p>
    </x-slot>

    <script>
        window.PRODUCTOS = {{ \Illuminate\Support\Js::from($productosJs) }};
        window.CART_ADD_URL = {{ \Illuminate\Support\Js::from(route('cart.add')) }};
        window.MAX_UNIDADES = {{ (int) $maxUnidades }};

        function carta() {
            return {
                abierto: false,
                producto: null,
                cantidad: 1,
                enviando: false,
                aviso: '',
                avisoError: false,
                temporizador: null,

                abrir(id) {
                    this.producto = window.PRODUCTOS[id];
                    this.cantidad = 1;
                    this.abierto = true;
                },
                cerrar() {
                    this.abierto = false;
                },
                maximo() {
                    return Math.max(1, Math.min(window.MAX_UNIDADES, this.producto ? this.producto.stock : 1));
                },
                mas() {
                    if (this.cantidad < this.maximo()) this.cantidad++;
                },
                menos() {
                    if (this.cantidad > 1) this.cantidad--;
                },
                mostrarAviso(texto, error) {
                    this.aviso = texto;
                    this.avisoError = error;
                    clearTimeout(this.temporizador);
                    this.temporizador = setTimeout(() => { this.aviso = ''; }, 4000);
                },
                async anadir() {
                    if (this.enviando || !this.producto) return;
                    this.enviando = true;

                    try {
                        const respuesta = await fetch(window.CART_ADD_URL, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify({
                                id_producto: this.producto.id,
                                cantidad: this.cantidad,
                            }),
                        });

                        if (respuesta.status === 401 || respuesta.status === 419) {
                            window.location.reload();
                            return;
                        }

                        const datos = await respuesta.json();

                        if (respuesta.ok && datos.success) {
                            this.cerrar();
                            this.mostrarAviso(datos.message, false);
                            window.dispatchEvent(new CustomEvent('cart-updated', { detail: { count: datos.count } }));
                        } else {
                            this.mostrarAviso(datos.message || 'No se ha podido añadir el producto.', true);
                        }
                    } catch (e) {
                        this.mostrarAviso('Error de conexión. Inténtalo de nuevo.', true);
                    } finally {
                        this.enviando = false;
                    }
                },
            };
        }
    </script>

    <div class="py-8" x-data="carta()" @keydown.escape.window="cerrar()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 sm:p-6">

                @forelse ($categorias as $categoria)
                    <section class="mb-10 last:mb-0">
                        <h2 class="text-center text-3xl font-bold bg-white py-3 px-4 rounded-md mx-auto w-full sm:w-2/3 lg:w-1/2">
                            {{ $categoria->nombre }}
                        </h2>
                        @if ($categoria->descripcion)
                            <p class="text-center text-gray-300 text-sm mt-2">{{ $categoria->descripcion }}</p>
                        @endif

                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mt-5">
                            @foreach ($categoria->productos as $producto)
                                @php $agotado = $producto->stock < 1; @endphp
                                <button type="button"
                                        @if (! $agotado) @click="abrir({{ $producto->id_producto }})" @endif
                                        @disabled($agotado)
                                        class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center text-center border border-gray-300 transition
                                               {{ $agotado ? 'opacity-60 cursor-not-allowed' : 'hover:scale-105 hover:shadow-xl cursor-pointer' }}">
                                    <img src="{{ asset($producto->imagen) }}" alt="{{ $producto->nombre }}"
                                         class="w-24 h-24 object-contain" loading="lazy">
                                    <h3 class="mt-3 text-lg font-semibold text-black">{{ $producto->nombre }}</h3>
                                    <p class="text-gray-600">{{ number_format((float) $producto->precio_unitario, 2, ',', '.') }} €</p>
                                    @if ($agotado)
                                        <span class="mt-2 text-sm font-semibold text-red-600">Agotado</span>
                                    @else
                                        <span class="mt-2 text-sm text-amber-700 underline">Ver detalles</span>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    </section>
                @empty
                    <p class="text-center text-white py-10">
                        Todavía no hay productos en la carta.
                    </p>
                @endforelse
            </div>
        </div>

        <!-- Aviso (toast) -->
        <div x-show="aviso" x-cloak x-transition
             class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 max-w-sm w-[90%] rounded-lg shadow-lg px-4 py-3 text-white"
             :class="avisoError ? 'bg-red-600' : 'bg-green-600'" role="status">
            <span x-text="aviso"></span>
            <template x-if="!avisoError">
                <a href="{{ route('cart.index') }}" class="ml-2 underline font-semibold">Ver mi reserva</a>
            </template>
        </div>

        <!-- Modal de producto -->
        <div x-show="abierto" x-cloak class="fixed inset-0 z-40 flex items-center justify-center p-4" role="dialog" aria-modal="true">
            <div class="absolute inset-0 bg-black/60" @click="cerrar()"></div>

            <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md p-6" x-show="abierto" x-transition>
                <template x-if="producto">
                    <div class="text-center">
                        <p class="text-xs uppercase tracking-widest text-gray-500" x-text="producto.categoria"></p>
                        <h3 class="text-2xl font-bold mt-1" x-text="producto.nombre"></h3>

                        <img :src="producto.imagen" :alt="producto.nombre" class="w-40 h-40 object-contain mx-auto my-4">

                        <p class="text-gray-700" x-text="producto.descripcion || 'Sin descripción.'"></p>
                        <p class="text-3xl font-bold mt-3"><span x-text="producto.precio"></span> €</p>
                        <p class="text-sm text-gray-500 mt-1">
                            Quedan <span x-text="producto.stock"></span> unidades
                        </p>

                        <div class="flex items-center justify-center gap-4 mt-5">
                            <button type="button" @click="menos()" class="w-10 h-10 rounded-full border border-gray-400 text-xl hover:bg-gray-100" aria-label="Quitar una unidad">−</button>
                            <span class="text-2xl font-semibold w-8" x-text="cantidad"></span>
                            <button type="button" @click="mas()" class="w-10 h-10 rounded-full border border-gray-400 text-xl hover:bg-gray-100" aria-label="Añadir una unidad">+</button>
                        </div>

                        <div class="flex justify-center gap-3 mt-6">
                            <button type="button" @click="cerrar()"
                                    class="px-5 py-2 rounded-md border border-gray-400 text-gray-800 hover:bg-gray-100">
                                Cerrar
                            </button>
                            <button type="button" @click="anadir()" :disabled="enviando"
                                    class="px-5 py-2 rounded-md bg-green-600 text-white font-semibold hover:bg-green-700 disabled:opacity-50">
                                <span x-show="!enviando">Añadir a mi reserva</span>
                                <span x-show="enviando" x-cloak>Añadiendo…</span>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-app-layout>

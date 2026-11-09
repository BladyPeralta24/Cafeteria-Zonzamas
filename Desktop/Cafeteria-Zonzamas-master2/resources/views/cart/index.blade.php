<x-app-layout>
    <x-slot name="title">Mi reserva · Cafetería Zonzamas</x-slot>

    <x-slot name="header">
        <h1 class="font-semibold text-2xl text-gray-800 leading-tight">Mi reserva</h1>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if ($items->isEmpty())
                <div class="bg-white shadow-sm sm:rounded-lg p-8 text-center">
                    <p class="text-gray-700 text-lg">Tu reserva está vacía.</p>
                    <a href="{{ route('dashboard') }}"
                       class="inline-block mt-4 px-5 py-2 rounded-md bg-[#ddb86a] text-black font-semibold hover:bg-[#c9a24f]">
                        Ver la carta
                    </a>
                </div>
            @else
                <div class="bg-white shadow-sm sm:rounded-lg divide-y">
                    @foreach ($items as $item)
                        <div class="p-4 flex flex-wrap items-center gap-4">
                            <img src="{{ asset($item->producto->imagen) }}" alt="{{ $item->producto->nombre }}"
                                 class="w-16 h-16 object-contain">

                            <div class="flex-1 min-w-[8rem]">
                                <p class="font-semibold">{{ $item->producto->nombre }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ number_format((float) $item->producto->precio_unitario, 2, ',', '.') }} € / ud.
                                </p>
                            </div>

                            <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <label for="cantidad-{{ $item->id }}" class="sr-only">Cantidad</label>
                                <input id="cantidad-{{ $item->id }}" type="number" name="cantidad"
                                       value="{{ $item->cantidad }}" min="1"
                                       max="{{ min($maxUnidades, max(1, $item->producto->stock)) }}"
                                       class="w-20 rounded-md border-gray-300">
                                <button type="submit" class="text-sm px-3 py-2 rounded-md border border-gray-400 hover:bg-gray-100">
                                    Actualizar
                                </button>
                            </form>

                            <p class="w-24 text-right font-semibold">
                                {{ number_format($item->importe, 2, ',', '.') }} €
                            </p>

                            <form method="POST" action="{{ route('cart.destroy', $item) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm underline">
                                    Quitar
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6 mt-6">
                    <dl class="space-y-1 text-sm text-gray-600">
                        <div class="flex justify-between">
                            <dt>Base imponible</dt>
                            <dd>{{ number_format($base, 2, ',', '.') }} €</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>IGIC ({{ rtrim(rtrim(number_format($igicRate, 2, ',', ''), '0'), ',') }}%, incluido en el precio)</dt>
                            <dd>{{ number_format($igic, 2, ',', '.') }} €</dd>
                        </div>
                    </dl>
                    <p class="flex justify-between text-xl font-bold mt-3 pt-3 border-t">
                        <span>Total</span>
                        <span>{{ number_format($total, 2, ',', '.') }} €</span>
                    </p>

                    <form method="POST" action="{{ route('cart.checkout') }}" class="mt-6">
                        @csrf
                        <label for="hora_recogida" class="block font-medium text-gray-800">
                            ¿A qué hora lo recoges?
                        </label>
                        <p class="text-sm text-gray-500">
                            Horario de la cafetería: {{ $apertura }} a {{ $cierre }}. La reserva es para hoy.
                        </p>
                        <input id="hora_recogida" type="time" name="hora_recogida" required
                               min="{{ $apertura }}" max="{{ $cierre }}" step="300"
                               value="{{ old('hora_recogida') }}"
                               class="mt-2 rounded-md border-gray-300">
                        @error('hora_recogida')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror

                        <div class="mt-5 flex flex-wrap gap-3">
                            <button type="submit"
                                    class="px-6 py-3 rounded-md bg-green-600 text-white font-semibold hover:bg-green-700">
                                Confirmar reserva
                            </button>
                            <a href="{{ route('dashboard') }}"
                               class="px-6 py-3 rounded-md border border-gray-400 text-gray-800 hover:bg-gray-100">
                                Seguir eligiendo
                            </a>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

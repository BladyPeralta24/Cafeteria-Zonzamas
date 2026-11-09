<x-app-layout>
    <x-slot name="title">Mis reservas · Cafetería Zonzamas</x-slot>

    <x-slot name="header">
        <h1 class="font-semibold text-2xl text-gray-800 leading-tight">Mis reservas</h1>
    </x-slot>

    @php
        $colores = [
            'pendiente' => 'bg-yellow-100 text-yellow-800',
            'preparada' => 'bg-blue-100 text-blue-800',
            'recogida' => 'bg-green-100 text-green-800',
            'cancelada' => 'bg-gray-200 text-gray-600',
        ];
    @endphp

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @forelse ($reservas as $reserva)
                <article class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <div>
                            <h2 class="text-lg font-bold">Reserva #{{ $reserva->id_reserva }}</h2>
                            <p class="text-sm text-gray-500">
                                {{ $reserva->fecha_reserva->format('d/m/Y') }} · recogida a las {{ $reserva->hora }}
                            </p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $colores[$reserva->estado] ?? '' }}">
                            {{ ucfirst($reserva->estado) }}
                        </span>
                    </div>

                    <ul class="mt-4 divide-y text-sm">
                        @foreach ($reserva->lineas as $linea)
                            <li class="py-2 flex justify-between">
                                <span>{{ $linea->cantidad }} × {{ $linea->producto->nombre }}</span>
                                <span>{{ number_format((float) $linea->importe_linea, 2, ',', '.') }} €</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="flex flex-wrap items-center justify-between gap-3 mt-4 pt-4 border-t">
                        <p class="font-bold text-lg">Total: {{ number_format((float) $reserva->total, 2, ',', '.') }} €</p>

                        @if ($reserva->estado === 'pendiente')
                            <form method="POST" action="{{ route('reservas.cancelar', $reserva) }}"
                                  onsubmit="return confirm('¿Seguro que quieres cancelar esta reserva?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-sm px-4 py-2 rounded-md border border-red-400 text-red-700 hover:bg-red-50">
                                    Cancelar reserva
                                </button>
                            </form>
                        @endif
                    </div>
                </article>
            @empty
                <div class="bg-white shadow-sm sm:rounded-lg p-8 text-center">
                    <p class="text-gray-700 text-lg">Todavía no has hecho ninguna reserva.</p>
                    <a href="{{ route('dashboard') }}"
                       class="inline-block mt-4 px-5 py-2 rounded-md bg-[#ddb86a] text-black font-semibold hover:bg-[#c9a24f]">
                        Ver la carta
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>

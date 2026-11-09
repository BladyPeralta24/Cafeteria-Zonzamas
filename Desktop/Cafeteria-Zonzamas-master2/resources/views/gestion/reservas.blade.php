<x-app-layout>
    <x-slot name="title">Gestión de reservas · Cafetería Zonzamas</x-slot>

    <x-slot name="header">
        <h1 class="font-semibold text-2xl text-gray-800 leading-tight">Gestión de reservas</h1>
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
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <form method="GET" action="{{ route('gestion.reservas') }}"
                  class="bg-white shadow-sm sm:rounded-lg p-4 flex flex-wrap items-end gap-4">
                <div>
                    <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                    <input id="fecha" type="date" name="fecha" value="{{ $fecha }}" class="rounded-md border-gray-300">
                </div>
                <label class="flex items-center gap-2 text-sm text-gray-700 pb-2">
                    <input type="checkbox" name="todas" value="1" @checked($verTodas) class="rounded border-gray-300">
                    Incluir recogidas y canceladas
                </label>
                <button type="submit" class="px-4 py-2 rounded-md bg-[#ddb86a] font-semibold hover:bg-[#c9a24f]">Filtrar</button>
            </form>

            @forelse ($reservas as $reserva)
                <article class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <div>
                            <h2 class="text-lg font-bold">
                                #{{ $reserva->id_reserva }} · {{ $reserva->hora }} · {{ $reserva->cliente->name }}
                            </h2>
                            @if ($reserva->cliente->telefono)
                                <p class="text-sm text-gray-500">Tel. {{ $reserva->cliente->telefono }}</p>
                            @endif
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $colores[$reserva->estado] ?? '' }}">
                            {{ ucfirst($reserva->estado) }}
                        </span>
                    </div>

                    <ul class="mt-3 text-sm list-disc ms-5">
                        @foreach ($reserva->lineas as $linea)
                            <li>{{ $linea->cantidad }} × {{ $linea->producto->nombre }}</li>
                        @endforeach
                    </ul>

                    <div class="flex flex-wrap items-center justify-between gap-3 mt-4 pt-4 border-t">
                        <p class="font-bold">Total: {{ number_format((float) $reserva->total, 2, ',', '.') }} €</p>

                        <div class="flex gap-2">
                            @if ($reserva->estado === 'pendiente')
                                <form method="POST" action="{{ route('gestion.reservas.update', $reserva) }}">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="estado" value="preparada">
                                    <button type="submit" class="px-4 py-2 rounded-md bg-blue-600 text-white text-sm hover:bg-blue-700">Marcar preparada</button>
                                </form>
                            @endif
                            @if ($reserva->estado === 'preparada')
                                <form method="POST" action="{{ route('gestion.reservas.update', $reserva) }}">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="estado" value="recogida">
                                    <button type="submit" class="px-4 py-2 rounded-md bg-green-600 text-white text-sm hover:bg-green-700">Marcar recogida</button>
                                </form>
                            @endif
                            @if ($reserva->estaActiva())
                                <form method="POST" action="{{ route('gestion.reservas.update', $reserva) }}"
                                      onsubmit="return confirm('¿Cancelar la reserva #{{ $reserva->id_reserva }}? Se devolverá el stock.');">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="estado" value="cancelada">
                                    <button type="submit" class="px-4 py-2 rounded-md border border-red-400 text-red-700 text-sm hover:bg-red-50">Cancelar</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="bg-white shadow-sm sm:rounded-lg p-8 text-center text-gray-700">
                    No hay reservas para esta fecha.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>

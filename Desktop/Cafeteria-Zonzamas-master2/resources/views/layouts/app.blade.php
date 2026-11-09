<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Cafetería Zonzamas') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Mensajes -->
            @if (session('success') || session('error'))
                <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                    @if (session('success'))
                        <div class="rounded-md bg-green-100 border border-green-300 text-green-800 px-4 py-3" role="status">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="rounded-md bg-red-100 border border-red-300 text-red-800 px-4 py-3" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            @endif

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <footer class="bg-gray-800 text-white text-center p-4 text-sm">
                © {{ date('Y') }} CIFP Zonzamas:
                <a class="font-bold underline" href="https://cifpzonzamas.es/" target="_blank" rel="noopener">www.cifpzonzamas.es</a>
            </footer>
        </div>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased"
          style="background: url('{{ asset('images/background.jpg') }}') no-repeat center center fixed; background-size: cover;">

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

            <!-- Card Login -->
            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-2xl">
                
                <!-- Logo PT di dalam card -->
                <div class="mb-4 text-center">
                    <img src="{{ asset('images/logo.PNG') }}" alt="Logo PT" class="w-32 h-auto mx-auto">
                </div>

                <!-- Judul -->
                <div class="mb-6 text-center">
                    <h2 class="text-2xl font-bold text-gray-800">Login Aplikasi Helpdesk SLA</h2>
                </div>

                <!-- Form Login -->
                {{ $slot }}

                <!-- Footer -->
                <div class="mt-6 text-center text-sm text-gray-500 border-t pt-4">
                    © 2025 PT JSP - All Rights Reserved
                </div>
            </div>
        </div>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Instansi</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="font-sans antialiased">
    <div class="flex h-screen bg-gray-100">
        
        @include('layouts.navigation-instansi')

        <div class="flex-1 flex flex-col overflow-hidden lg:ml-64">
            
            <main class="flex-1 overflow-x-hidden overflow-y-auto pt-16">
                <div class="container mx-auto px-6 py-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
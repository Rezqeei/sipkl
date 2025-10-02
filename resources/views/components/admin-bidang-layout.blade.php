<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPKL - Admin Bidang</title>
    {{-- Pastikan ini mengarah ke file CSS/JS Anda --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#eef3fa]">
    <div class="flex min-h-screen" x-data="{}">
        
        
        @include('layouts.navigation-bidang')
        
        <div class="flex-1 flex flex-col">
            
            
            <div class="flex-1 ml-64 pt-16">
                <main class="p-8">
                    {{ $slot }}
                </main>
            </div>
            
        </div>
    </div>
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Forest Adventure') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="//unpkg.com/alpinejs" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
    
    @stack('styles')
</head>

<body class="bg-[#f8fafc] text-slate-900 antialiased">
    
    <div id="app" class="flex flex-col min-h-screen">

        @auth
            @if(Auth::user()->role === 'admin')
                <x-navbar-admin />
            @else
                <x-navbar-customer />
            @endif
        @endauth

        <main class="flex-grow">
            @yield('content')
        </main>

        <x-footer />

    </div>

    @stack('scripts')
</body>
</html>

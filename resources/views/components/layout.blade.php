<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{config('app.name')}}</title>
                <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
         <link href="{{ asset('css/app.css') }}" rel="stylesheet">
       
        @livewireStyles

        <script src="https://kit.fontawesome.com/{{config('app.fontawesome')}}.js" crossorigin="anonymous"></script>
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
       
       
    </head>
    <body class="antialiased">
        <div>
            @if (Route::has('login'))
                
                @auth
                    <x-navigation />
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>
                    
                @endauth
                
            @endif
            <div class="px-5">
            {{ $slot }}
            </div>
        </div>
        <x-footer />

        <script src="{{ asset('js/app.js')}}" defer ></script>
        @livewireScripts
        @stack('scripts')

    
    </body>
        
</html>
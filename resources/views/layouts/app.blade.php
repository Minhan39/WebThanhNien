<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" type="image/x-icon" href="{{ Vite::asset('resources/images/logo.png') }}" />
        <title>Tuổi trẻ Bến Cát</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <style>
            *{
                font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            }
            .btn-primary{
                background-color: rgba(17, 74, 160, 1);
                border-color: rgba(17, 74, 160, 1);
            }
            .btn-info{
                background-color: #737CB0;
                border-color: #737CB0;
            }
            .btn-warning{
                background-color: #EAEEFF;
                border-color: #EAEEFF;
            }
            .btn-danger{
                background-color: #D1A617;
                border-color: #D1A617;
            }
            .btn-primary:hover{
                background-color: rgba(17, 74, 160, 0.9);
            }
            .btn-info:hover{
                background-color: rgba(115, 124, 176, 0.9);
                border-color: #737CB0;
            }
            .btn-warning:hover{
                background-color: rgba(234, 238, 255, 0.9);
                border-color: #EAEEFF;
            }
            .btn-danger:hover{
                background-color: rgba(209, 166, 23, 0.9);
                border-color: #D1A617;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    </body>
</html>

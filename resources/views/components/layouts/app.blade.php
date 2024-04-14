<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="{{ asset('css/index.css')}}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

        <title>{{ $title ?? 'Wiki Импорт' }}</title>
    </head>
    <body>
        <main>
            <div class="visually_hidden">
                <h1>Сервис импорта статей из Википедии</h1>
            </div>

            <div class="content-wrapper">
                {{ $slot }}
            </div>
        </main>
    </body>
</html>

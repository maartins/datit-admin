<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Datit</title>

        <link rel="stylesheet" type="text/css" href="{{URL::asset('css/app.css')}}">
    </head>
    <body>
        <div class="header">
            <h1 id="title">Datit/@yield('title')</h1>

            <ul>
                <li><a href="">Rēķins</a></li>
                <li><a href="/clients">Klienti</a></li>
                <li><a href="">Pakalpojumi</a></li>
            </ul>
        </div>

        @yield('content')
    </body>
</html>

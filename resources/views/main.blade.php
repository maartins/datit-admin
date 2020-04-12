<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Datit</title>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
        <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{URL::asset('css/app.css')}}" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="header">
            <h1 id="title">Datit/@yield('title')</h1>

            <ul>
                <li><a href="/clients">Klienti</a></li>
                <li><a href="/invoices">Rēķini</a></li>
                <li><a href="/services">Pakalpojumi</a></li>
            </ul>
        </div>

        @yield('content')
    </body>
</html>

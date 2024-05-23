<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">        

        <title>Vaud Cul'</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body>
        <h1 class="text-3xl font-bold underline">hello</h1>
        <div id="app">
            <h1>Vaud Cul'</h1>
            <app></app>
        </div>
    </body>
</html>

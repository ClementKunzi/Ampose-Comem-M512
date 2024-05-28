<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">        

        <title>Vaud Cul'</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body>        
        <div id="app" class="layout min-h-screen font-sans bg-tv-eggshell">
            <h1>Vaud Cul'</h1>
            <app></app>
        </div>
    </body>
</html>

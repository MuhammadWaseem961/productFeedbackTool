<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite(['resources/css/app.css', 'resources/js/app.js','resources/js/assets/js/jquery.js',"resources/js/assets/js/bootstrap.bundle.js",'resources/js/assets/js/hc-sticky.min.js',"resources/js/assets/js/jquery.waypoints.min.js",'resources/js/assets/js/theme.js'])
    </head>
    <body>
        <div id="app"></div>
    </body>
</html>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Image crop upload</title>

        <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet" />
    </head>
    <body class="bg-light">
        <div class="container mt-4">
            <h2 class="mb-3">Image crop upload</h2>
            <div id="app">
                <crop-upload></crop-upload>
            </div>
        </div>

        <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
    </body>
</html>

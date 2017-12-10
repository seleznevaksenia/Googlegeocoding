<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <link href = "{{ asset('css/app.css') }}" rel="stylesheet">
    <link href = "http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
</head>
<body>
<div id="app">

    <div class="container-fluid">
        <h3>Google App</h3>
        <router-view></router-view>
    </div>
</div>
<footer class="text-center text-white">Selezneva &copy 2017 All Rights Reserved</footer>
<script src="{{ asset('js/app.js') }}"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={!! config('geocoding.key') !!}"></script>
</body>
</html>

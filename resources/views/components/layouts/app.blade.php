<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap-icons/font/bootstrap-icons.css') }}">

    <style>
        tr td {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    {{ $slot }}
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>

</html>

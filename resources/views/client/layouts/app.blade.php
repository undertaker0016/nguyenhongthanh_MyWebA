<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body>

@include('client._partials.header')

@include('client._partials.navbar')

<div class="container py-4">

    @yield('content')

</div>

@include('client._partials.footer')

</body>

</html>
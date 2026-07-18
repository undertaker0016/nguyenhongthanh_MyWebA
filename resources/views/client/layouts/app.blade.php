<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>


    @vite([
        'resources/css/client.css',
        'resources/js/client.js'
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
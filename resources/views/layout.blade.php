<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
</head>
<body>

    @include('partials.header')
    @include('partials.nav')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

</body>
</html>
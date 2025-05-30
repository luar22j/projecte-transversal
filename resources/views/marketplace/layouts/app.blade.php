<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Burgers & Roll | Marketplace</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite([
        'resources/css/app.css',
        'resources/css/marketplace/nav.css',
        'resources/js/marketplace/nav.js',
        'resources/js/marketplace/user-data.js',
        'resources/js/marketplace/card-template.js',
        'resources/js/marketplace/burgers.js',
        'resources/css/font/font.css',
        'resources/js/components/navigation.js'
    ])
    <link
        rel="shortcut icon"
        href="{{ asset('images/icon.png') }}"
        type="image/x-icon"
    />
</head>
<body>
    @include('components.header')
    @include('components.navigation')
    @yield('content')
    @include('components.footer')
</body>
</html>
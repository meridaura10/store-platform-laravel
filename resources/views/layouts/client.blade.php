<!DOCTYPE html>
<html data-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <title>Blog</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-base-200">
    <div class="w-full ">
        @include('client.components.header')
        <div class="min-h-content">
            @yield('content')
        </div>
    </div>
</body>

</html>

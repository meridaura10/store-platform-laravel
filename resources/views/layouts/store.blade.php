<!DOCTYPE html>
<html data-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    @vite('resources/css/app.css')
    <title>store admin panel</title>
</head>

<body class="bg-gray-200 min-h-screen">
    @include('store.components.header')
    <div class="flex flex-row  min-h-[calc(100vh-48px)]">
        <div class="w-full">
            @yield('content')
        </div>
    </div>
</body>

</html>


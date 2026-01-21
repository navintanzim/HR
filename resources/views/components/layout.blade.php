<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'My App' }}</title>
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-50">
    {{ $slot }}
</body>
</html>

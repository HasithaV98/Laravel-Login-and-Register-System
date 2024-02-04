<!DOCTYPE html>
<html lang="en">
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">

@foreach ($css as $path)
    <link href="{{ $path }}" rel="stylesheet">
    @endforeach
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
<x-app-layout>
@include($body)
</x-app-layout>
@foreach($script as $path)
    <script src="{{ $path }}"></script>
    @endforeach

</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Héctor</title>
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>
<body>
    <h1>👋 Hola, {{ $nombre }}</h1>
    <p>Esto es una prueba de estilos cargados desde public/css</p>

    <a href="{{ url('/') }}">Volver al inicio</a>
</body>
</html>

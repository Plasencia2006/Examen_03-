<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Calzados</title>
    @vite('resources/css/app.css')
    <style>
        /* Fondo con gradiente sutil */
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }
        
        /* Navegación mejorada */
        nav {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
        }
        
        /* Logo con efecto mejorado */
        .logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        /* Enlaces de navegación mejorados */
        .nav-link {
            position: relative;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            background: rgba(96, 165, 250, 0.1);
            color: #93c5fd;
            transform: translateY(-2px);
        }
        
        /* Mensaje de éxito mejorado */
        .success-message {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
            border-left: 4px solid #a7f3d0;
        }
        
        /* Contenedor principal */
        .container {
            max-width: 1200px;
        }
    </style>
</head>
<body class="text-gray-200 min-h-screen">

    <nav class="text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold logo">👟 Tienda de Calzados</h1>
            <div class="flex space-x-2">
                <a href="{{ route('marcas.index') }}" class="nav-link hover:text-gray-400">Marcas</a>
                <a href="{{ route('calzados.index') }}" class="nav-link hover:text-gray-400">Calzados</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-6">
        @if(session('success'))
            <div class="text-white p-4 rounded mb-4 success-message">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

</body>
</html>
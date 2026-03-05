<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIP2CARS — Página no encontrada</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --rojo: #C0001A; --negro: #0A0A0A; --gris: #1C1C1E;
            --plata: #AEAEB2; --blanco: #F5F5F7;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: var(--negro); color: var(--blanco);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
        }
        .error-container { text-align: center; padding: 2rem; max-width: 500px; }
        .error-code {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 10rem; line-height: 1;
            color: var(--gris);
            text-shadow: 0 0 0 2px var(--rojo);
            -webkit-text-stroke: 2px var(--rojo);
        }
        .error-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2rem; letter-spacing: 3px;
            margin: 1rem 0 .5rem;
        }
        .error-title span { color: var(--rojo); }
        .error-desc { color: var(--plata); font-size: .95rem; line-height: 1.6; margin-bottom: 2rem; }
        .btn-back {
            background: var(--rojo); color: #fff; border: none;
            padding: .7rem 1.8rem; border-radius: 8px;
            font-weight: 600; font-size: .9rem; text-decoration: none;
            display: inline-flex; align-items: center; gap: .5rem;
            transition: background .2s;
        }
        .btn-back:hover { background: #a30016; color: #fff; }
        .car-icon { font-size: 3rem; color: var(--rojo); margin-bottom: 1rem; opacity: .7; }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="car-icon"><i class="bi bi-car-front"></i></div>
        <div class="error-code">404</div>
        <div class="error-title">Página <span>No Encontrada</span></div>
        <p class="error-desc">
            El recurso que buscas no existe o fue eliminado.<br>
            Verifica la URL o regresa al panel principal.
        </p>
        <a href="{{ route('vehiculos.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Volver al panel
        </a>
    </div>
</body>
</html>
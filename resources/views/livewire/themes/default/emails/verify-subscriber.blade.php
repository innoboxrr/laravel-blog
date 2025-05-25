<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirma tu suscripción</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            padding: 0;
            margin: 0;
        }

        .container {
            max-width: 600px;
            margin: 2rem auto;
            background-color: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            padding: 2rem;
        }

        .header {
            text-align: center;
            background: linear-gradient(to right, #7c3aed, #6366f1);
            padding: 1.5rem;
            color: white;
        }

        .icon {
            background-color: #e0e7ff;
            padding: 1rem;
            border-radius: 9999px;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .content {
            padding: 1.5rem;
            font-size: 1rem;
            line-height: 1.6;
            text-align: center;
        }

        .button {
            display: inline-block;
            background: linear-gradient(to right, #f97316, #facc15);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: bold;
            text-decoration: none;
            margin-top: 1rem;
            transition: filter 0.2s;
        }

        .button:hover {
            filter: brightness(1.1);
        }

        .footer {
            margin-top: 2rem;
            font-size: 0.85rem;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">
                <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v16l-4-4H4a1 1 0 01-1-1V4z"/>
                </svg>
            </div>
            <div class="title">Confirma tu suscripción</div>
        </div>

        <div class="content">
            <p>Hola {{ $subscriber->name ?? 'estimado suscriptor' }},</p>
            <p>Gracias por suscribirte al blog <strong>{{ $blog->name }}</strong>.</p>
            <p>Haz clic en el siguiente botón para confirmar tu suscripción:</p>

            <a href="{{ $verificationUrl }}" class="button">Confirmar suscripción</a>

            <p style="margin-top: 1.5rem;">Si no te suscribiste a este blog, puedes ignorar este correo.</p>
        </div>

        <div class="footer">
            © {{ date('Y') }} {{ $blog->name }}. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>

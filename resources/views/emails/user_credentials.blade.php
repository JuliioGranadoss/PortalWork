<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credenciales de Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f3f8;
        }
        .container {
            max-width: 670px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 3px;
            text-align: center;
            box-shadow: 0 6px 18px 0 rgba(0,0,0,.06);
            padding: 40px 35px;
        }
        .highlight {
            font-weight: bold;
            color: #20e277;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: rgba(69, 80, 86, 0.7411764705882353);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>¡Hola {{ $name }}!</h2>
        <p>Aquí están tus credenciales de acceso:</p>
        <div class="credentials">
            <p><span class="highlight">Nombre de Usuario:</span> {{ $name }}</p>
            <p><span class="highlight">Contraseña:</span> {{ $password }}</p>
        </div>
        <p>Por favor, mantén esta información segura y no la compartas con nadie.</p>
    </div>
    <div class="footer">
        <p>Este correo electrónico fue generado automáticamente. Por favor, no respondas a este mensaje.</p>
    </div>
</body>
</html>

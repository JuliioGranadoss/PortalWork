<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credenciales de Usuario</title>
    <style>
        body {
            background-color: darkgrey; 
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .card {
            width: 500px;
            margin: 20px auto;
            border-radius: 10px;
            background-color: #ffffff; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-content {
            padding: 20px;
            color: #024997; 
        }

        .highlight {
            font-weight: bold;
        }

        .img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: block;
        }

        .footer {
            padding: 10px;
            text-align: center;
            background-color: #f2f3f8; 
            border-top: 1px solid #ddd;
            color: rgba(69, 80, 86, 0.7411764705882353); 
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-content">
            <img src="{{ asset('img/Logo_Ayuntamiento.png') }}" alt="" class="img">
            <h2 style="text-align: center;">¡Hola {{ $name }}!</h2>
            <p>Aquí están tus credenciales de acceso:</p>
            <div class="credentials">
                <p><span class="highlight">Nombre de Usuario:</span> {{ $name }}</p>
                <p><span class="highlight">Contraseña:</span> {{ $password }}</p>
            </div>
            <p>Por favor, mantén esta información segura y no la compartas con nadie.</p>
        </div>
    </div>
    <div class="footer">
        <p>Este correo electrónico fue generado automáticamente. Por favor, no respondas a este mensaje.</p>
    </div>
</body>
</html>

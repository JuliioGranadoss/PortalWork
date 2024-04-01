<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credenciales de Usuario</title>
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

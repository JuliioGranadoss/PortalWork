<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Movimiento de Stock - {{ $model->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header .logo {
            width: 150px;
        }
        .header .info {
            text-align: right;
        }
        .header .info p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .details {
            margin-bottom: 20px;
        }
        .details p {
            margin: 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        .footer p {
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="{{ asset('img/Logo_Ayuntamiento.png') }}" alt="" class="img">
            </div>
            <div class="info">
                <p><strong>Lugar:</strong> {{ $model->place->name }}</p>
                <p><strong>Personal:</strong> {{ $model->personal->name }} {{ $model->personal->surname }}</p>
                <p><strong>Fecha:</strong> {{ $model->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Producto ID</th>
                    <th>Nombre del Producto</th>
                    <th>Lugar</th>
                    <th>Personal</th>
                    <th>Cantidad</th>
                    <th>Tipo de Movimiento</th>
                </tr>
            </thead>
            <tbody>
                @foreach($model->stockHistory as $history)
                    <tr>
                        <td>{{ $history->product_id }}</td>
                        <td>{{ $history->name }}</td>
                        <td>{{ $history->place->name }}</td>
                        <td>{{ $history->personal->name }} {{ $history->personal->surname }}</td>
                        <td>{{ $history->quantity }}</td>
                        <td>{{ $history->type == 1 ? 'Entrada' : 'Salida' }}</td> 
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Ayuntamiento Alhaurín el Grande.</p>
        </div>
    </div>
</body>
</html>

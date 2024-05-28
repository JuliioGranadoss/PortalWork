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
        .borderless th, .borderless td {
            border: 0px;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .table p {
            margin: 5px 0;
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
        <table class="table borderless">
            <tr>
                <td width="50%">
                    <p><strong>Ayuntamiento de Alhaurin el Grande</strong></p>
                    <p><strong>Personal:</strong> {{ $model->personal->name }} {{ $model->personal->surname }}</p>
                    <p><strong>Lugar:</strong> {{ $model->place->name }}</p>
                    <p><strong>Fecha:</strong> {{ $model->created_at->format('d/m/Y') }}</p>
                </td>
                <td width="50%" style="text-align: right;">
                    <img src="{{ asset('img/Logo_Ayuntamiento.png') }}" width="150px" style="margin-right: 25px" class="img">
                </td>
            </tr>
        </table>
        <table class="table">
            <thead>
                <tr>
                    <th width="26.66%">Producto</th>
                    <th width="26.66%">Lugar</th>
                    <th width="26.66%"">Personal</th>
                    <th width="10%">Cant.</th>
                    <th width="10%">Mov.</th>
                </tr>
            </thead>
            <tbody>
                @foreach($model->stockHistory as $history)
                    <tr>
                        <td width="26.66%">{{ $history->name }}</td>
                        <td width="26.66%">{{ $history->place->name }}</td>
                        <td width="26.66%">{{ $history->personal->name }} {{ $history->personal->surname }}</td>
                        <td width="10%" style="text-align: right">{{ $history->quantity }}</td>
                        <td width="10%">{{ $history->type == 1 ? 'Entrada' : 'Salida' }}</td> 
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

@extends('layouts.main')

@section('title')
    {{ __('Inicio') }} @parent
@stop

@section('head_css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Roboto', sans-serif;
        }

        .welcome-container {
            max-width: 700px;
            margin: 40px auto;
            padding: 30px;
            text-align: center;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .welcome-header {
            color: #343a40;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .welcome-text {
            color: #6c757d;
            font-size: 18px;
            margin-bottom: 30px;
        }

        .welcome-options {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .welcome-options li {
            margin-bottom: 15px;
        }

        .welcome-options a {
            display: block;
            padding: 12px 20px;
            color: #fff;
            background-color: #007bff;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .welcome-options a:hover {
            background-color: #0056b3;
            color: #fff;
        }
    </style>
@stop

@section('content')
    <div class="welcome-container mt-5">
        <h1 class="welcome-header">Bienvenido a PortalWork</h1>
        <p class="welcome-text">PortalWork es una plataforma de gestión laboral que ofrece herramientas para la administración de trabajadores, ofertas de trabajo, movimientos de stock y más. <br> Seleccione una opción para continuar:</p>
        <ul class="welcome-options">
            @role('admin')
            <li><a href="{{ route('workers.index') }}"><i class="fas fa-users"></i> Gestión de Trabajadores</a></li>
            <li><a href="{{ route('offers.index') }}"><i class="fas fa-briefcase"></i> Ofertas de Trabajo</a></li>
            <li><a href="{{ route('users.index') }}"><i class="fas fa-user-cog"></i> Gestión de Usuarios</a></li>
            @endrole

            @role('manager')
            <li><a href="{{ route('stockmovements.index') }}"><i class="fas fa-exchange-alt"></i> Movimientos de Stock</a></li>
            <li><a href="{{ route('products.index') }}"><i class="fas fa-boxes"></i> Productos</a></li>
            <li><a href="{{ route('stockhistories.index') }}"><i class="fas fa-history"></i> Historial de Stock</a></li>
            @endrole

            @role('worker')
            <li><a href="{{ route('workers.index') }}"><i class="fas fa-user"></i> Trabajadores</a></li>
            <li><a href="{{ route('jobboards.index') }}"><i class="fas fa-clipboard-list"></i> Bolsa de Trabajo</a></li>
            <li><a href="{{ route('jobs.index') }}"><i class="fas fa-briefcase"></i> Puestos de Trabajo</a></li>
            <li><a href="{{ route('degreetitles.index') }}"><i class="fas fa-graduation-cap"></i> Titulaciones</a></li>
            @endrole
        </ul>
    </div>
@stop

@section('scripts')
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
@stop

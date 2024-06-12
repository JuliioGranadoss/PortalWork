@extends('layouts.main')

@section('title')
    {{ __('Bienvenida') }} @parent
@stop

@section('head_css')
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        p {
            color: #666;
            font-size: 16px;
            margin-bottom: 30px;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin-bottom: 10px;
        }
    </style>
@stop

@section('content')
    <div class="container mt-5">
        <h1>Bienvenido a PortalWork</h1>
        <p>PortalWork es una plataforma de gestión laboral que ofrece herramientas para la administración de trabajadores, ofertas de trabajo, movimientos de stock y más. Seleccione una opción para continuar:</p>
        <ul>
            @role('admin')
            <li><a href="{{ route('workers.index') }}">Gestión de Trabajadores</a></li>
            <li><a href="{{ route('offers.index') }}">Ofertas de Trabajo</a></li>
            @endrole

            @role('manager')
            <li><a href="{{ route('stockmovements.index') }}">Movimientos de Stock</a></li>
            <li><a href="{{ route('products.index') }}">Productos</a></li>
            @endrole

            @role('worker')
            <li><a href="{{ route('jobboards.index') }}">Bolsa de Trabajo</a></li>
            @endrole
        </ul>
    </div>
@stop

@section('scripts')

@stop

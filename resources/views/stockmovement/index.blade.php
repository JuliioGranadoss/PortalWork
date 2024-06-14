@extends('layouts.main')

@section('title')
    {{ __('Movimientos de Stock') }} @parent
@stop

@section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-dark text-center text-sm-left h2-sm">{{__('Movimientos de Stock')}}
                        <a class="btn btn-success float-sm-right" href="javascript:void(0)" id="createNewModelMovement"><i class="fa fa-plus" ></i> {{ __('Añadir movimiento y buscar por código de barras') }}</a>
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Filtros -->
                    <div class="row mb-3">
                        <movements-filters ref="movementsfilters"></movements-filters>
                    </div>
                    {{$dataTable->table()}}
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
        <stockmovement-crud ref="stockmovementcrud"></stockmovement-crud>
@endsection
 
@section('scripts')
    @include('includes.datatables')

    {{$dataTable->scripts()}}
@stop

@extends('layouts.main')

@section('title')
    {{ __('Productos') }} @parent
@stop

@section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-dark text-center text-sm-left h2-sm">{{__('Productos')}}           
                        <a class="btn btn-primary float-sm-right mr-2" href="javascript:void(0)" id="createNewProductStock"><i class="fa fa-barcode"></i> {{ __('Insertar código de barras') }}</a>
                        <a class="btn btn-success float-sm-right mr-2" href="javascript:void(0)" id="createNewModel"><i class="fa fa-plus"></i> {{ __('Añadir producto') }}</a>
                    </h4>
                </div>
                <div class="card-body">
                    {{$dataTable->table()}}
                </div>
            </div>   

        </div>
        <!-- /.container-fluid -->
        <product-crud ref="productcrud"></product-crud>
        <product-stock ref="productstock"></product-stock>
@endsection
 
@section('scripts')
    @include('includes.datatables')

    {{$dataTable->scripts()}}
@stop

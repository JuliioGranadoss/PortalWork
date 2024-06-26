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
                        <a class="btn btn-success float-sm-right mr-2" href="javascript:void(0)" id="createNewModel"><i class="fa fa-plus"></i> {{ __('Añadir producto') }}</a>
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Filtros -->
                    <div class="row mb-3">
                        <products-filters ref="productsfilters"></products-filters>
                    </div>
                    
                    {{$dataTable->table()}}
                </div>
            </div>   

        </div>
        <!-- /.container-fluid -->
        <product-crud ref="productcrud"></product-crud>
@endsection
 
@section('scripts')
    @include('includes.datatables')

    {{$dataTable->scripts()}}
@stop

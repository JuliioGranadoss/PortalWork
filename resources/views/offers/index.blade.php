@extends('layouts.main')

@section('title')
    {{ __('Ofertas') }} @parent
@stop

@section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-dark text-center text-sm-left h2-sm">{{__('Ofertas')}}
                    <a class="btn btn-success float-sm-right" href="javascript:void(0)" id="createNewModel"><i class="fa fa-plus"></i> {{ __('Añadir') }}</a>                    </h4>
                </div>
                <div class="card-body">
                    {{$dataTable->table()}}
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
        <offer-crud ref="offercrud"></offer-crud>
@endsection
 
@section('scripts')
    @include('includes.datatables')

    {{$dataTable->scripts()}}
@stop

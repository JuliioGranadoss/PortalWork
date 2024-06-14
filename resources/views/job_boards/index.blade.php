@extends('layouts.main')

@section('title')
    {{ __('Bolsa de Trabajo') }} @parent
@stop

@section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-dark text-center text-sm-left h2-sm">{{__('Bolsa de Trabajo')}}
                    <a class="btn btn-primary float-sm-right" href="{{ route('welcome') }}" style="position: relative; top: 15px; margin-left: 10px;"><i class="fa fa-arrow-left"></i> {{ __('Volver al inicio') }}</a>
                    <a class="btn btn-success float-sm-right" href="javascript:void(0)" id="createNewModel"><i class="fa fa-plus"></i> {{ __('Añadir bolsa de trabajo') }}</a>
                    </h4>
                </div>
                <div class="card-body">
                    {{$dataTable->table()}}
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
        <jobboard-crud ref="jobboardcrud"></jobboard-crud>
@endsection
 
@section('scripts')
    @include('includes.datatables')

    {{$dataTable->scripts()}}
@stop

@extends('layouts.main')


@section('title')
    {{ __('Trabajadores') }} @parent
@stop


@section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-dark text-center text-sm-left h2-sm">{{__('Trabajadores')}}
                    <a class="btn btn-primary float-sm-right" href="{{ route('welcome') }}" style="position: relative; top: 15px; margin-left: 10px;"><i class="fa fa-arrow-left"></i> {{ __('Volver al inicio') }}</a>
                    @role('admin')
                    <a class="btn btn-success float-sm-right" href="javascript:void(0)" id="createNewModel">
                        <i class="fa fa-plus"></i> {{ __('Añadir trabajador') }}
                    </a>
                    @endrole
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Filtros -->
                    <div class="row mb-3">
                        <workers-filters ref="workersfilters"></workers-filters>
                    </div>
                    {{$dataTable->table()}}
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
        <worker-crud ref="workercrud"></worker-crud>
@endsection
 
@section('scripts')
    @include('includes.datatables')

    {{$dataTable->scripts()}}
@stop

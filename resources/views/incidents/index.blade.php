@extends('layouts.main')

@section('title')
    {{ __('Incidencias') }} @parent
@stop

@section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-dark text-center text-sm-left h2-sm">{{__('Incidencias')}}
                        <a class="btn btn-success float-sm-right" href="javascript:void(0)" id="createNewModel"><i class="fa fa-plus" ></i> {{ __('Añadir incidencia') }}</a>
                    </h4>
                </div>
                <div class="card-body">
                    {{$dataTable->table()}}
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
        <incident-crud ref="incidentcrud"></incident-crud>
@endsection
 
@section('scripts')
    @include('includes.datatables')

    {{$dataTable->scripts()}}
@stop

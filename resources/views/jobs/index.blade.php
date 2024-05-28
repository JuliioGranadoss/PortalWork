@extends('layouts.main')

@section('title')
    {{ __('Puestos de trabajo') }} @parent
@stop

@section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-dark text-center text-sm-left h2-sm">{{__('Puesto de trabajo')}}
                    <a class="btn btn-success float-sm-right" href="javascript:void(0)" id="createNewJob"><i class="fa fa-plus"></i> {{ __('Añadir puesto de trabajo') }}</a>
                    </h4>
                </div>
                <div class="card-body">
                    {{$dataTable->table()}}
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
        <job-crud ref="jobcrud"></job-crud>
@endsection
 
@section('scripts')
    @include('includes.datatables')

    {{$dataTable->scripts()}}
@stop

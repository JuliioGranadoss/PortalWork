@extends('layouts.main')

@section('title')
    {{ __('Contacto') }} @parent
@stop

@section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-dark text-center text-sm-left h2-sm">{{__('Contacto')}}
                    </h4>
                </div>
                <div class="card-body">
                    {{$dataTable->table()}}
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
        <contact-crud ref="contactcrud"></contact-crud>
@endsection
 
@section('scripts')
    @include('includes.datatables')

    {{$dataTable->scripts()}}
@stop

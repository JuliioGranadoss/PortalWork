@extends('layouts.main')

@section('title')
    {{ __('Calendario') }} @parent
@stop

@section('content')
        <!-- Begin Page Content -->
        <div class="container">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-dark text-center text-sm-left h2-sm">{{__('Calendario')}} </h4>
                </div>
                <div class="card-body">
                    <livewire:calendar />
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
@endsection
 
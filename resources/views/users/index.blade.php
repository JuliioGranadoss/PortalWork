@extends('layouts.main')

@section('title')
    {{ __('Usuarios') }} @parent
@stop

@section('content')
        @php
            use App\Models\Config;
        @endphp

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-dark text-center text-sm-left h2-sm">{{__('Usuarios')}}
                        <a class="btn btn-success float-sm-right" href="javascript:void(0)" id="createNewModel"><i class="fa fa-plus" ></i> {{ __('Añadir usuario') }}</a>
                    </h4>
                </div>
                <div class="card-body">
                    <h5>Total de usuarios: <span id="total_users">{{$total_users}}</span> / {{Config::where('key', 'max_user_number')->first()->value ?? null}}</h5>

                    <div class="table-responsive">
                        {{$dataTable->table()}}
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
        <user-crud ref="userscrud"></user-crud>
@endsection
 
@section('scripts')
    @include('includes.datatables')

    {{$dataTable->scripts()}}

    <script>
        $(document).ready(function() {
            // Inicializar DataTables
            var dataTable = $('#users-table').DataTable();

            // Manejar el evento de dibujo de DataTables
            dataTable.on('draw', function() {
            // Cambiar el texto dentro del elemento con ID "users-table_info"
            var nuevoTexto = $("#users-table_info").text().replace("registros", "usuarios");
            $("#users-table_info").text(nuevoTexto);
            });
        });
    </script>
@stop

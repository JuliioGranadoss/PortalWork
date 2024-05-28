@extends('layouts.main')

@section('title')
    {{ __('Detalles del trabajador')}} @parent
@stop

@section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <input type="hidden" id="worker_id" value="{{$model->id}}">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-dark text-center text-sm-left h2-sm">{{ __('Detalles del trabajador ') . $model->name . ' ' . $model->surname}}
                    <a class="btn btn-primary float-sm-right" href="/workers"><i class="fa fa-arrow-left"></i> {{ __('Volver') }}</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Convocatoria:</strong> {{ $model->announcement->format('d/m/Y') }}</p>
                            <p><strong>Nombre:</strong> {{ $model->name }}</p>
                            <p><strong>Apellido:</strong> {{ $model->surname }}</p>
                            <p><strong>DNI:</strong> {{ $model->dni }}</p>
                            <p><strong>Correo electrónico:</strong> {{ $model->email }}</p>
                            <p><strong>Fecha de nacimiento:</strong> {{ $model->birth_date->format('d/m/Y') }}</p>
                            <p><strong>Descripción:</strong> {{ $model->description }}</p>
                            <p><strong>Dirección:</strong> {{ $model->address }}</p>
                            <p><strong>Titular:</strong> {{ $model->job->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Código postal:</strong> {{ $model->postal_code }}</p>
                            <p><strong>Provincia:</strong> {{ $model->province }}</p>
                            <p><strong>Localidad:</strong> {{ $model->location }}</p>
                            <p><strong>Teléfono:</strong> {{ $model->phone }}</p>
                            <p><strong>Teléfono 2:</strong></p> {{ $model->phone2 }}
                            <p><strong>Permiso B (turismo):</strong> {{ $model->driving_license_B == 1 ? 'Si' : 'No' }}</p>
                            <p><strong>Permiso A (moto):</strong> {{ $model->driving_license_A == 1 ? 'Si' : 'No' }}</p>
                            <p><strong>Estado:</strong> {{ $model->status == 1 ? 'Alta' : 'Baja' }}</p>
                            <p><strong>Bolsa de trabajo:</strong> {{ $model->jobBoard->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-dark text-center text-sm-left h2-sm">{{ __('Títulos')}}
                    <a class="btn btn-success float-sm-right" href="javascript:void(0)" id="createNewDegree"><i class="fa fa-plus"></i> {{ __('Añadir título') }}</a>
                    </h4>
                </div>
                <div class="card-body">
                    {!! $degreeDataTable->table() !!}
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-dark text-center text-sm-left h2-sm">{{ __('Experiencia laboral')}}
                    <a class="btn btn-success float-sm-right" href="javascript:void(0)" id="createNewExperience"><i class="fa fa-plus"></i> {{ __('Añadir experiencia laboral') }}</a>
                    </h4>
                </div>
                <div class="card-body">
                    {!! $experienceDataTable->table() !!}
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-dark text-center text-sm-left h2-sm">{{ __('Habilidades')}}
                    <a class="btn btn-success float-sm-right" href="javascript:void(0)" id="createNewOther"><i class="fa fa-plus"></i> {{ __('Añadir habilidades') }}</a>
                    </h4>
                </div>
                <div class="card-body">
                    {!! $otherDataTable->table() !!}
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-dark text-center text-sm-left h2-sm">{{ __('Ofertas de trabajo')}}
                    <a class="btn btn-success float-sm-right" href="javascript:void(0)" id="createNewWorkerOffer"><i class="fas fa-check"></i> {{ __('Seleccionar oferta') }}</a>
                    </h4>
                </div>
                <div class="card-body">
                    {!! $workerofferDataTable->table() !!}
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
        <degree-crud ref="degreecrud"></degree-crud>
        <experience-crud ref="experiencecrud"></experience-crud>
        <other-crud ref="othercrud"></other-crud>
        <job-crud ref="jobcrud"></job-crud>
        <workeroffer-crud ref="workeroffercrud"></workeroffer-crud>
@endsection
         
@section('scripts')
    @include('includes.datatables')
    {!! $degreeDataTable->scripts() !!}
    {!! $experienceDataTable->scripts() !!}
    {!! $otherDataTable->scripts() !!}
    {!! $workerofferDataTable->scripts() !!}
@endsection

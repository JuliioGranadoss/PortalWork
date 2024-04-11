@extends('layouts.main')

@section('title')
    {{ __('Detalles del producto')}} @parent
@stop

@section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <input type="hidden" id="product_id" value="{{$model->id}}">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-dark text-center text-sm-left h2-sm">{{ __('Detalles del producto ') . $model->name}}
                    <a class="btn btn-primary float-sm-right" href="/products"><i class="fa fa-arrow-left"></i> {{ __('Volver') }}</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nombre:</strong> {{ $model->name }}</p>
                            <p><strong>Descripción:</strong> {{ $model->description }}</p>
                            <p><strong>Proveedor:</strong> {{ $model->provider->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Existencias:</strong> {{ $model->stock }}</p>
                            <p><strong>Estado:</strong> {{ $model->status == 1 ? 'Disponible' : 'No disponible' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-dark text-center text-sm-left h2-sm">{{__('Categorías')}}
                    <a class="btn btn-success float-sm-right" href="javascript:void(0)" id="createNewCategoryProduct"><i class="fa fa-check"></i> {{ __('Seleccionar categoría') }}</a>
                    </h4>
                </div>
                <div class="card-body">
                    {!! $categoryproductDataTable->table() !!}
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-dark text-center text-sm-left h2-sm">{{__('Códigos de barras')}}
                    <a class="btn btn-success float-sm-right" href="javascript:void(0)" id="createNewBarcode"><i class="fa fa-plus"></i> {{ __('Añadir código de barras') }}</a>
                    </h4>
                </div>
                <div class="card-body">
                    {!! $barcodeDataTable->table() !!}
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
        <categoryproduct-crud ref="categoryproductcrud"></categoryproduct-crud>
        <barcode-crud ref="barcodecrud"></barcode-crud>
@endsection
         
@section('scripts')
    @include('includes.datatables')
        
    {!! $categoryproductDataTable->scripts() !!}
    {!! $barcodeDataTable->scripts() !!}
@endsection

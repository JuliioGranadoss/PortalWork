<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barcode;
use App\DataTables\BarcodeDataTable;

class BarcodeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function data()
    {
        $model = Barcode::get();
        return response()->json($model);
    }

    /**
     * Show the datatable.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(BarcodeDataTable $dataTable)
    {
        return $dataTable->render('barcodes.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = Barcode::updateOrCreate(
            
            ['id' => $request->id],
            [
                'product_id' => $request->product_id,
                'code' => $request->code,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Barcode  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Barcode::find($id);
        return response()->json($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Barcode  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Barcode::find($id);
        $model->delete();

        return response()->json(['success' => __('Código de barras eliminado correctamente.')]);
    }
}

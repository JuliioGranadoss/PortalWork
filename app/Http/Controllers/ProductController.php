<?php

namespace App\Http\Controllers;

use App\DataTables\BarcodeDataTable;
use App\DataTables\CategoryProductDataTable;
use Illuminate\Http\Request;
use App\Models\Product;
use App\DataTables\ProductDataTable;
use App\DataTables\ProviderDataTable;

class ProductController extends Controller
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
        $model = Product::get();
        return response()->json($model);
    }

    /**
     * Show the datatable.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('products.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = Product::updateOrCreate(
            ['id' => $request->id],
            [
                'provider_id' => $request->provider_id,
                'name' => $request->name,
                'description' => $request->description,
                'stock' => $request->stock,
                'status' => $request->status,
            ]
        );
    }

    /**
     * Show the detailss page.
     *
     * @param  \App\Product  $model
     * @return \Illuminate\Http\Response
     */
    public function show(
        $id, 
        CategoryProductDataTable $categoryProductDataTable,
        BarcodeDataTable $barcodeDataTable
        )
    {
        $model = Product::find($id);
    
        return view('products.show', [
            'model' => $model,
            'categoryproductDataTable' => $categoryProductDataTable->html()->minifiedAjax(route('categoryproducts.index', $id)),
            'barcodeDataTable' => $barcodeDataTable->html()->minifiedAjax(route('barcodes.index', $id)),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Product::find($id);
        return response()->json($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Product::find($id);
        $model->delete();

        return response()->json(['success' => __('Producto eliminado correctamente.')]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockHistory;
use App\DataTables\StockHistoryDataTable;

class StockHistoryController extends Controller
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
        $model = StockHistory::get();
        return response()->json($model);
    }

    /**
     * Show the datatable.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(StockHistoryDataTable $dataTable)
    {
        return $dataTable->render('stockhistories.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = StockHistory::updateOrCreate(
            ['id' => $request->id],
            [
                'product_id' => $request->product_id,
                'name' => $request->name,
                'quantity' => $request->quantity,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StockHistory  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = StockHistory::find($id);
        return response()->json($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StockHistory  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = StockHistory::find($id);
        $model->delete();

        return response()->json(['success' => __('Historial eliminado correctamente.')]);
    }
}

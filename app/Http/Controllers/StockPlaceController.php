<?php

namespace App\Http\Controllers;

use App\DataTables\StockPlaceDataTable;
use Illuminate\Http\Request;
use App\Models\StockPlace;

class StockPlaceController extends Controller
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
        $model = StockPlace::get();
        return response()->json($model);
    }

    /**
     * Show the datatable.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(StockPlaceDataTable $dataTable)
    {
        return $dataTable->render('stockplace.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = StockPlace::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'status' => $request->status
            ]
        );

        return response()->json(['success' => __('Lugar guardado correctamente.'), 'model' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StockPlace  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = StockPlace::find($id);

        return response()->json($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $model = StockPlace::find($id);
        $model->delete();
    }
}

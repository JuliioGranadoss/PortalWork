<?php

namespace App\Http\Controllers;

use App\DataTables\StockPersonalDataTable;
use Illuminate\Http\Request;
use App\Models\StockPersonal;

class StockPersonalController extends Controller
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
        $model = StockPersonal::get();
        return response()->json($model);
    }

    /**
     * Show the datatable.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(StockPersonalDataTable $dataTable)
    {
        return $dataTable->render('stockpersonal.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = StockPersonal::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'surname' => $request->surname,
                'dni' => $request->dni,
                'phone' => $request->phone,
                'status' => $request->status
            ]
        );

        return response()->json(['success' => __('Personal guardado correctamente.'), 'model' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StockPersonal  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = StockPersonal::find($id);

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
        $model = StockPersonal::find($id);
        $model->delete();
        return response()->json(['success' => __('Personal eliminado correctamente.')]);
    }
}

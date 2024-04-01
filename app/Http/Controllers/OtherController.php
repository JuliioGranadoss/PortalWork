<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Other;
use App\DataTables\OtherDataTable;

class OtherController extends Controller
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
        $model = Other::get();
        return response()->json($model);
    }

    /**
     * Show the datatable.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(OtherDataTable $dataTable, $id)
    {
        return $dataTable->render('others.index', ['id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = Other::updateOrCreate(
            ['id' => $request->id],
            [
                'worker_id' => $request->worker_id,
                'name' => $request->name,
                'description' => $request->description,
                'score' => $request->score,
            ]
        );

        return response()->json(['success' => __('Otros datos guardados correctamente.'), 'model' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Other  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Other::find($id);

        return response()->json($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Other  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Other::find($id);
        $model->delete();

        return response()->json(['success' => __('Otros datos eliminados correctamente.')]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DegreeTitle;
use App\DataTables\DegreeTitleDataTable;

class DegreeTitleController extends Controller
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
        $model = DegreeTitle::get();
        return response()->json($model);
    }

    /**
     * Show the datatable.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(DegreeTitleDataTable $dataTable)
    {
        return $dataTable->render('degree_titles.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = DegreeTitle::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
            ]
        );

        return response()->json(['success' => __('Tituñación guardada correctamente.'), 'model' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DegreeTitle  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = DegreeTitle::find($id);

        return response()->json($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DegreeTitle  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = DegreeTitle::find($id);
        $model->delete();

        return response()->json(['success' => __('Titulación eliminada correctamente.')]);
    }
}

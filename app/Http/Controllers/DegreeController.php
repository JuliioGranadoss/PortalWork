<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Degree;
use App\DataTables\DegreeDataTable;
use App\Models\Worker;
use Carbon\Carbon;

class DegreeController extends Controller
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
        $model = Degree::get();
        return response()->json($model);
    }

    /**
     * Show the datatable.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(DegreeDataTable $dataTable, $id)
    {
        return $dataTable->render('degrees.index', ['id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = Degree::updateOrCreate(
            ['id' => $request->id],
            [
                'worker_id' => $request->worker_id,
                'name' => $request->name,
                'institution' => $request->institution,
                'start' => Carbon::parse($request->start)->format('Y-m-d'),
                'end' => Carbon::parse($request->end)->format('Y-m-d'),
                'score' => $request->score,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Degree  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Degree::find($id);
        return response()->json($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Degree  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Degree::find($id);
        $model->delete();

        return response()->json(['success' => __('Título eliminado correctamente.')]);
    }
}

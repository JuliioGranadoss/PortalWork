<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\DataTables\JobDataTable;

class JobController extends Controller
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
        $model = Job::get();
        return response()->json($model);
    }

    /**
     * Show the datatable.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(JobDataTable $dataTable, $id)
    {
        return $dataTable->render('jobs.index', ['id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = Job::updateOrCreate(
            ['id' => $request->id],
            [
                'worker_id' => $request->worker_id,
                'name' => $request->name,
                'score' => $request->score
            ]
        );

        return response()->json(['success' => __('Trabajo guardado correctamente.'), 'model' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Job  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Job::find($id);

        return response()->json($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Job  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Job::find($id);
        $model->delete();

        return response()->json(['success' => __('Trabajo eliminado correctamente.')]);
    }
}

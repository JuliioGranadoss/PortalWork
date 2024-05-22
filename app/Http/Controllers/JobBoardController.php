<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobBoard;
use App\DataTables\JobBoardDataTable;
use Carbon\Carbon;

class JobBoardController extends Controller
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
        $model = JobBoard::get();
        return response()->json($model);
    }

    /**
     * Show the datatable.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(JobBoardDataTable $dataTable)
    {
        return $dataTable->render('job_boards.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = JobBoard::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'init' => $request->Carbon::parse($request->init)->format('Y-m-d'),
                'end' => $request->Carbon::parse($request->end)->format('Y-m-d'),
            ]
        );

        return response()->json(['success' => __('Bolsa de trabajo guardada correctamente.'), 'model' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JobBoard  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = JobBoard::find($id);

        return response()->json($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JobBoard  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = JobBoard::find($id);
        $model->delete();

        return response()->json(['success' => __('Bolsa de trabajo eliminada correctamente.')]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Experience;
use App\DataTables\ExperienceDataTable;
use Carbon\Carbon;

class ExperienceController extends Controller
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
        $model = Experience::get();
        return response()->json($model);
    }

    /**
     * Show the datatable.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(ExperienceDataTable $dataTable, $id)
    {
        return $dataTable->render('experiences.index', ['id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = Experience::updateOrCreate(
            ['id' => $request->id],
            [
                'worker_id' => $request->worker_id,
                'name' => $request->name,
                'company' => $request->company,
                'start' => Carbon::parse($request->start)->format('Y-m-d'),
                'end' => Carbon::parse($request->end)->format('Y-m-d'),
            ]
        );

        return response()->json(['success' => __('Experiencia laboral guardada correctamente.'), 'model' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Experience  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Experience::find($id);

        return response()->json($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Experience  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Experience::find($id);
        $model->delete();

        return response()->json(['success' => __('Experiencia laboral eliminada correctamente.')]);
    }
}

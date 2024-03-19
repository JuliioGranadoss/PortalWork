<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incident;
use App\DataTables\IncidentDataTable;
use App\DataTables\ApartmentDataTable;
use App\DataTables\DeviceDataTable;

class IncidentController extends Controller
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
        $model = Incident::get();
        return response()->json($model);
    }

    /**
     * Show the datatable.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(IncidentDataTable $dataTable)
    {
        return $dataTable->render('incidents.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = Incident::updateOrCreate(
            ['id' => $request->id],
            [
                'title' => $request->title,
                'description' => $request->description,
                'priority' => $request->priority,
                'status' => $request->status,
                'creator_id' => auth()->user()->id,
                'assigned_id ' => $request->assigned_id
            ]
        );

        return response()->json(['success' => __('Incidencia guardada correctamente.'), 'model' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Incident  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Incident::find($id);

        return response()->json($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Incident  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Incident::find($id);
        $model->status = -1;
        $model->save();

        return response()->json(['success' => __('Incidencia eliminada correctamente.')]);
    }
}

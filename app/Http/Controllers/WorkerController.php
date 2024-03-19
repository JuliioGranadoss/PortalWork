<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Worker;
use App\DataTables\WorkerDataTable;
use App\DataTables\ApartmentDataTable;
use App\DataTables\DeviceDataTable;
use Carbon\Carbon;

class WorkerController extends Controller
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
        $model = Worker::get();
        return response()->json($model);
    }

    /**
     * Show the datatable.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(WorkerDataTable $dataTable)
    {
        return $dataTable->render('workers.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = Worker::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'surname' => $request->surname,
                'dni' => $request->dni,
                'email' => $request->email,
                'birth_date' => Carbon::parse($request->birth_date)->format('Y-m-d'),
                'description' => $request->description,
                'address' => $request->address,
                'postal_code' => $request->postal_code,
                'province' => $request->province,
                'location' => $request->location,
                'phone' => $request->phone,
                'status' => $request->status,
            ]
        );

        return response()->json(['success' => __('Trabajador guardado correctamente.'), 'model' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Worker  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Worker::find($id);

        return response()->json($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Worker  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Worker::find($id);
        $model->status = -1;
        $model->save();

        return response()->json(['success' => __('Trabajador eliminado correctamente.')]);
    }
}

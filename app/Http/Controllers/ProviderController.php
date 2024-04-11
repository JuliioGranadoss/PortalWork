<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provider;
use App\DataTables\ProviderDataTable;

class ProviderController extends Controller
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
        $model = Provider::get();
        return response()->json($model);
    }

    /**
     * Show the datatable.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(ProviderDataTable $dataTable)
    {
        return $dataTable->render('providers.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = Provider::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'status' => $request->status,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Provider  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Provider::find($id);
        return response()->json($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Provider::find($id);
        $model->delete();

        return response()->json(['success' => __('Proveedor eliminado correctamente.')]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\DataTables\OfferDataTable;

class OfferController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /*$this->middleware('auth');*/
    }

    public function data()
    {
        $model = Offer::get();
        return response()->json($model);
    }

    /**
     * Show the datatable.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(OfferDataTable $dataTable)
    {
        return $dataTable->render('offers.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = Offer::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'description' => $request->description,
                'status' => $request->status,
            ]
        );

        return response()->json(['success' => __('Oferta guardada correctamente.'), 'model' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Offer  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Offer::find($id);

        return response()->json($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Offer  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Offer::find($id);
        $model->status = -1;
        $model->save();

        return response()->json(['success' => __('Oferta eliminada correctamente.')]);
    }
}

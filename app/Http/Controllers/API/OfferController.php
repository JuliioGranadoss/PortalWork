<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Offer;

class OfferController extends Controller
{
    /**
     * Show all offers.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return response()->json(Offer::where('status', 1)->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Offer  $model
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Offer::find($id);

        return response()->json($model);
    }
}

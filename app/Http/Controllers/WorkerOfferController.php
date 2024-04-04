<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use App\Models\WorkOffer;
use Illuminate\Http\Request;

class WorkerOfferController extends Controller
{
    /**
     * Muestra las ofertas asociadas a un trabajador.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function offers($id)
    {
        // Obtener el trabajador
        $worker = Worker::findOrFail($id);

        // Obtener las ofertas asociadas al trabajador
        $offers = $worker->workOffers;

        return view('workeroffers.offers', compact('worker', 'offers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $workOffer = WorkOffer::updateOrCreate(
            ['id' => $request->id],
            [
                'worker_id' => $request->worker_id,
                'offer_id' => $request->offer_id
            ]
        );

        return response()->json(['success' => __('Oferta de trabajo guardada correctamente.'), 'workOffer' => $workOffer]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $workOffer = WorkOffer::find($id);

        $workOffer->delete();

        return response()->json(['success' => __('Oferta de trabajo eliminada correctamente.')]);
    }
}

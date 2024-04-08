<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use App\Models\WorkerOffer;
use App\Models\Offer;
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
        $offers = $worker->offers;

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
        $model = WorkerOffer::updateOrCreate(
            ['worker_id' => $request->worker_id, 'offer_id' => $request->offer_id],
            [
                'offer_id' => $request->offer_id,
            ]
        );
        return response()->json(['success' => __('Oferta guardada correctamente.'), 'model' => $model]);
    }

    /**
     * Obtener las ofertas de trabajo disponibles para asignar a un trabajador.
     *
     * @return \Illuminate\Http\Response
     */
    public function availableOffers($id)
    {
        $worker = Worker::findOrFail($id);

        // Obtener todas las ofertas de trabajo que no están asignadas al trabajador
        $availableOffers = Offer::whereNotIn('id', $worker->offers()->pluck('id')->toArray())
            ->where('status', 1)
            ->get();

        // Retornar las ofertas disponibles como respuesta JSON
        return response()->json($availableOffers);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($worker_id, $offer_id)
    {
        $worker = Worker::findOrFail($worker_id);
        $worker->offers()->detach($offer_id);

        return response()->json(['success' => __('Oferta de trabajo eliminada correctamente.')]);
    }
}

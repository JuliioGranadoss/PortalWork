<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Worker;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class WorkerController extends Controller
{
    /**
     * Show all workers.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $model = Worker::get();
        return response()->json($model);
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
                'file_id' => $request->file_id
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
    public function show($id)
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

    /**
     * Assign an offer to a worker.
     *
     * @param  int  $worker_id
     * @param  int  $offer_id
     * @return \Illuminate\Http\Response
     */
    public function assignOffer($worker_id, $offer_id)
    {
        $worker = Worker::findOrFail($worker_id);
        $worker->offers()->attach($offer_id);

        return response()->json(['success' => __('Oferta asignada correctamente al trabajador.')]);
    }

    /**
     * Detach an offer from a worker.
     *
     * @param  int  $worker_id
     * @param  int  $offer_id
     * @return \Illuminate\Http\Response
     */
    public function detachOffer($worker_id, $offer_id)
    {
        $worker = Worker::findOrFail($worker_id);

        $worker->offers()->detach($offer_id);

        return response()->json(['success' => __('Oferta desvinculada correctamente del trabajador.')]);
    }

    /**
     * Update or add the worker's profile photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateOrAddProfilePhoto(Request $request, $id)
    {
        $worker = Worker::findOrFail($id);

        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('profile_photo')) {
            $profilePhoto = $request->file('profile_photo');

            // Guardar el archivo en el almacenamiento
            $filename = time() . '_' . $profilePhoto->getClientOriginalName();
            $path = $profilePhoto->storeAs('public/file/' . $id, $filename);

            // Crear una nueva entrada en la tabla files
            $file = new File();
            $file->title = $filename;
            $file->filename = $filename;
            $file->mime_type = $profilePhoto->getClientMimeType();
            $file->slug = $filename;
            $file->save();

            // Vincular el archivo al trabajador
            $worker->file_id = $file->id;
            $worker->save();
        }

        return response()->json(['success' => __('Foto de perfil actualizada correctamente.')]);
    }
}

<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Other;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class OtherController extends Controller
{
    /**
     * Show all other entries.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $others = Other::all();
        return response()->json($others);
    }

    /**
     * Store a newly created entry in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $other = Other::updateOrCreate(
            ['id' => $request->id],
            [
                'worker_id' => $request->worker_id,
                'name' => $request->name,
                'description' => $request->description,
                'score' => $request->score,
            ]
        );

        return response()->json(['success' => __('Habilidad guardada correctamente.'), 'model' => $other]);
    }

    /**
     * Show the form for editing the specified entry.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $other = Other::find($id);
        return response()->json($other);
    }

    /**
     * Show the form for editing the specified entry.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $other = Other::find($id);
        return response()->json($other);
    }

    /**
     * Remove the specified entry from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $other = Other::find($id);
        $other->delete();

        return response()->json(['success' => __('Habilidad eliminada correctamente.')]);
    }
}

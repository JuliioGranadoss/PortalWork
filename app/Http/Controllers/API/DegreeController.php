<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Degree;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class DegreeController extends Controller
{
    /**
     * Show all degrees.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $degrees = Degree::all();
        return response()->json($degrees);
    }

    /**
     * Store a newly created degree in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $degree = Degree::updateOrCreate(
            ['id' => $request->id],
            [
                'worker_id' => $request->worker_id,
                'name' => $request->name,
                'institution' => $request->institution,
                'start' => Carbon::parse($request->start)->format('Y-m-d'),
                'end' => Carbon::parse($request->end)->format('Y-m-d'),
                'score' => $request->score,
            ]
        );

        return response()->json(['success' => __('Título guardado correctamente.'), 'model' => $degree]);
    }

    /**
     * Show the form for editing the specified degree.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $degree = Degree::find($id);
        return response()->json($degree);
    }

    /**
     * Remove the specified degree from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $degree = Degree::find($id);
        $degree->delete();

        return response()->json(['success' => __('Título eliminado correctamente.')]);
    }
}

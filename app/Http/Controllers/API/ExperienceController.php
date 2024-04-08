<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Experience;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class ExperienceController extends Controller
{
    /**
     * Show all experiences.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $experiences = Experience::all();
        return response()->json($experiences);
    }

    /**
     * Store a newly created experience in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $experience = Experience::updateOrCreate(
            ['id' => $request->id],
            [
                'worker_id' => $request->worker_id,
                'name' => $request->name,
                'company' => $request->company,
                'start' => Carbon::parse($request->start)->format('Y-m-d'),
                'end' => Carbon::parse($request->end)->format('Y-m-d'),
                'score' => $request->score,
            ]
        );

        return response()->json(['success' => __('Experiencia laboral guardada correctamente.'), 'model' => $experience]);
    }

    /**
     * Show the form for editing the specified experience.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $experience = Experience::find($id);
        return response()->json($experience);
    }

    /**
     * Show the form for editing the specified experience.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $experience = Experience::find($id);
        return response()->json($experience);
    }

    /**
     * Remove the specified experience from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $experience = Experience::find($id);
        $experience->delete();

        return response()->json(['success' => __('Experiencia laboral eliminada correctamente.')]);
    }
}

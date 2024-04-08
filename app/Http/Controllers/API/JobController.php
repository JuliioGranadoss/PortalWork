<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Job;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class JobController extends Controller
{
    /**
     * Show all jobs.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $jobs = Job::all();
        return response()->json($jobs);
    }

    /**
     * Store a newly created job in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $job = Job::updateOrCreate(
            ['id' => $request->id],
            [
                'worker_id' => $request->worker_id,
                'name' => $request->name,
                'score' => $request->score,
            ]
        );

        return response()->json(['success' => __('Trabajo guardado correctamente.'), 'model' => $job]);
    }

    /**
     * Show the form for editing the specified job.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job = Job::find($id);
        return response()->json($job);
    }

    /**
     * Show the form for editing the specified job.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job = Job::find($id);
        return response()->json($job);
    }

    /**
     * Remove the specified job from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job = Job::find($id);
        $job->delete();

        return response()->json(['success' => __('Trabajo eliminado correctamente.')]);
    }
}

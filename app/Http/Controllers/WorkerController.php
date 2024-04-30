<?php

namespace App\Http\Controllers;

use App\DataTables\DegreeDataTable;
use App\DataTables\ExperienceDataTable;
use App\DataTables\JobDataTable;
use App\DataTables\OtherDataTable;
use App\DataTables\WorkerOfferDataTable;
use Illuminate\Http\Request;
use App\Models\Worker;
use App\DataTables\WorkerDataTable;
use App\Mail\SendUserCredentials;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class WorkerController extends Controller
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
        $model = Worker::get();
        return response()->json($model);
    }

    /**
     * Show the datatable.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(WorkerDataTable $dataTable)
    {
        return $dataTable->render('workers.index');
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
            ]
        );

        $user_id = $model->user_id ?? null;
        $user = User::find($user_id);
        $user = User::updateOrCreate(
            ['id' => $user_id],
            [
                'name' => $model->name . ' ' . $model->surname,
                'email' => $model->email,
                'password' => $user ? $user->password : Hash::make('123456')
            ]
        );
        
        $user->syncRoles(['worker']);

        if ($user->wasRecentlyCreated) {
            Mail::to($model->email)->send(new SendUserCredentials($model->name . ' ' . $model->surname, '123456'));
        }

        $model->user_id = $user->id;
        $model->save();

        return response()->json(['success' => __('Trabajador guardado correctamente.'), 'model' => $model]);
    }


    /**
     * Show the detailss page.
     *
     * @param  \App\Worker  $model
     * @return \Illuminate\Http\Response
     */
    public function show(
        $id, 
        DegreeDataTable $degreeDataTable, 
        ExperienceDataTable $experienceDataTable,
        JobDataTable $jobDataTable, 
        OtherDataTable $otherDataTable,
        WorkerOfferDataTable $workerofferDataTable
        )
    {
        $model = Worker::find($id);
    
        return view('workers.show', [
            'model' => $model,
            'degreeDataTable' => $degreeDataTable->html()->minifiedAjax(route('degrees.index', $id)),
            'experienceDataTable' => $experienceDataTable->html()->minifiedAjax(route('experiencies.index', $id)),
            'jobDataTable' => $jobDataTable->html()->minifiedAjax(route('jobs.index', $id)),
            'otherDataTable' => $otherDataTable->html()->minifiedAjax(route('others.index', $id)),
            'workerofferDataTable' => $workerofferDataTable->html()->minifiedAjax(route('workeroffers.index', $id))
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Worker  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

    public function sendCredentials($id)
    {
        $model = Worker::find($id);
        $password = Str::random(12);
        $user = $model->user;

        $user->password = Hash::make($password);
        $user->save();
        
        Mail::to($model->email)->send(new SendUserCredentials($model->name . ' ' . $model->surname, $password));

        return response()->json(['message' => '¡Email enviado!']);
    }

}
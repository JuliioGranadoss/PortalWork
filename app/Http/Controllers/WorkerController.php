<?php

namespace App\Http\Controllers;

use App\DataTables\DegreeDataTable;
use App\DataTables\ExperienceDataTable;
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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function data()
    {
        $model = Worker::get();
        return response()->json($model);
    }

    public function index(WorkerDataTable $dataTable)
    {
        return $dataTable->render('workers.index');
    }

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
                'phone2' => $request->phone2,
                'driving_license_B' => $request->driving_license_B,
                'driving_license_A' => $request->driving_license_A,
                'status' => $request->status,
                'job_id' => $request->job_id,
                'jobboard_id' => $request->jobboard_id,
            ]
        );

        $user = $model->user;

        // Generar una contraseña aleatoria de 12 caracteres
        $password = Str::random(12);

        if (!$user) {
            $user = User::create([
                'name' => $model->name . ' ' . $model->surname,
                'email' => $model->email,
                'password' => Hash::make($password),
            ]);

            $user->syncRoles(['worker']);

            Mail::to($model->email)->send(new SendUserCredentials($model->name . ' ' . $model->surname, $password));
        } else {
            $user->update([
                'name' => $model->name . ' ' . $model->surname,
                'email' => $model->email,
            ]);
        }

        $model->user_id = $user->id;
        $model->save();

        return response()->json(['success' => __('Trabajador guardado correctamente.'), 'model' => $model]);
    }

    public function show(
        $id,
        DegreeDataTable $degreeDataTable,
        ExperienceDataTable $experienceDataTable,
        OtherDataTable $otherDataTable,
        WorkerOfferDataTable $workerofferDataTable
    ) {
        $model = Worker::find($id);

        return view('workers.show', [
            'model' => $model,
            'degreeDataTable' => $degreeDataTable->html()->minifiedAjax(route('degrees.index', $id)),
            'experienceDataTable' => $experienceDataTable->html()->minifiedAjax(route('experiencies.index', $id)),
            'otherDataTable' => $otherDataTable->html()->minifiedAjax(route('others.index', $id)),
            'workerofferDataTable' => $workerofferDataTable->html()->minifiedAjax(route('workeroffers.index', $id))
        ]);
    }

    public function edit($id)
    {
        $model = Worker::find($id);
        return response()->json($model);
    }

    public function destroy($id)
    {
        $model = Worker::find($id);
        if ($model) {
            $user = $model->user;
            $model->delete();
            if ($user) {
                $user->delete();
            }
        }

        return response()->json(['success' => __('Trabajador eliminado correctamente.')]);
    }

    public function sendCredentials($id)
    {
        $model = Worker::find($id);
        if ($model) {
            $password = Str::random(12);
            $user = $model->user;

            if ($user) {
                $user->password = Hash::make($password);
                $user->save();

                Mail::to($model->email)->send(new SendUserCredentials($model->name . ' ' . $model->surname, $password));

                return response()->json(['message' => '¡Email enviado!']);
            }
        }

        return response()->json(['message' => 'No se pudo enviar el email.'], 400);
    }
}

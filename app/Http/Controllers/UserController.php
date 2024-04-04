<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\DataTables\UsersDataTable;

class UserController extends Controller
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

    /**
     * Show the datatable.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('users.index', [
            'total_users' => User::count()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]
        );

        $user->syncRoles([$request->role]);

        return response()->json(['success' => __('Usuario guardado correctamente.'), 'user' => $user, 'total' => User::count()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = User::find($id);
        $model->role = $model->getRole();
        return response()->json($model);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profileStore(Request $request)
    {
        $user = User::updateOrCreate(
            ['id' => auth()->user()->id],
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]
        );

        return response()->json(['success' => __('Usuario guardado correctamente.'), 'user' => $user]);
    }

    /**
     * Show the form for editing profile.
     */
    public function profile()
    {
        $model = User::find(auth()->user()->id);
        $model->role = $model->getRole();
        return response()->json($model);
    }

    public function checkEmail(Request $request)
    {
        return User::where('email', $request->email)->exists();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = User::find($id);
        $model->status = -1;
        $model->save();

        return response()->json(['success' => __('Usuario eliminado correctamente.')]);
    }



}

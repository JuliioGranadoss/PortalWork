<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\DataTables\FileDataTable;

class FileController extends Controller
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
        $model = File::get();
        return response()->json($model);
    }

    /**
     * Show the datatable.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(FileDataTable $dataTable)
    {
        return $dataTable->render('files.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->file) {
            $file = File::create([
                'title' => pathinfo($request->file->getClientOriginalName(), PATHINFO_FILENAME),
                'mime_type' => $request->file->extension()
            ]);

            $filename = $file->slug . '.' . $request->file->extension();

            $request->file->move(public_path('file') . '/' . time(), $filename);

            $file->source = 'file' . '/' . time() . '/' . $filename;
            $file->save();

            return response()->json(['success' => __('Archivo guardado correctamente.')]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\File  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = File::find($id);

        return response()->json($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\File  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = File::find($id);
        $model->delete();

        return response()->json(['success' => __('Archivo eliminado correctamente.')]);
    }
}

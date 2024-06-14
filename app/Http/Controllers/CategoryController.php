<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\DataTables\CategoryDataTable;

class CategoryController extends Controller
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
        $model = Category::get();
        return response()->json($model);
    }

    /**
     * Show the datatable.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('categories.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = Category::updateOrCreate(
            ['id' => $request->id],
            [
                'parent_id' => $request->parent_id,
                'name' => $request->name,
                'status' => $request->status,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Category::find($id);
        return response()->json($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Category::find($id);
        $model->delete();

        return response()->json(['success' => __('Categoría eliminada correctamente.')]);
    }
}

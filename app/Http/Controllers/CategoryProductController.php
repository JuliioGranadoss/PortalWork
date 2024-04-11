<?php

namespace App\Http\Controllers;

use App\DataTables\CategoryProductDataTable;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{

    /**
     * Show the datatable.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(CategoryProductDataTable $dataTable, $id)
    {
        return $dataTable->render('categoryproducts.index', ['id' => $id]);
    }

    /**
     * Muestra las categorías asociadas a un producto.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function categories($id)
    {
        // Obtener el producto
        $product = Product::findOrFail($id);

        // Obtener los productos asociados a una categoría
        $categories = $product->categories;

        return view('categoryproducts.categories', compact('product', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = CategoryProduct::updateOrCreate(
            ['product_id' => $request->product_id, 'category_id' => $request->category_id],
            [
                'category_id' => $request->category_id,
            ]
        );
        return response()->json(['success' => __('Categoría guardada correctamente.'), 'model' => $model]);
    }

    /**
     * Obtener categorías disponibles para asignar a un producto.
     * 
     * @return \Illuminate\Http\Response
     */
    public function availableCategories($id)
    {
        $product = Product::findOrFail($id);

        // Obtener todas las categorías que no están asignadas a un producto
        $availableCategories = Category::whereNotIn('id', $product->categories()->pluck('id')->toArray())
            ->where('status', 1)
            ->get();

        // Retornar las categorías disponibles como respuesta JSON
        return response()->json($availableCategories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id, $category_id)
    {
        $product = Product::findOrFail($product_id);
        $product->categories()->detach($category_id);

        return response()->json(['success' => __('Categoría eliminada correctamente.')]);
    }
}

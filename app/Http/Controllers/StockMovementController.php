<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockMovement;
use App\DataTables\StockMovementDataTable;
use App\Models\Barcode;
use App\Models\Product;
use App\Models\StockHistory;

class StockMovementController extends Controller
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
    public function index(StockMovementDataTable $dataTable)
    {
        return $dataTable->render('stockmovement.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = StockMovement::updateOrCreate(
            ['id' => $request->id],
            [
                'signature_id' => $request->signature_id,
                'place_id' => $request->place_id,
                'personal_id' => $request->personal_id,
                'status' => $request->status
            ]
        );

        return response()->json(['success' => __('Movimiento guardado correctamente.'), 'model' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StockMovement  $model
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = StockMovement::find($id);

        return response()->json($model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $model = StockMovement::find($id);
        $model->delete();
        return response()->json(['success' => __('Movimiento eliminado correctamente.')]);
    }

    public function searchByBarcode($barcode)
    {
        // Buscar el código de barras en la tabla 'barcodes'
        $barcodeEntry = Barcode::where('code', $barcode)->first();

        if (!$barcodeEntry) {
            return response()->json(['error' => 'Código de barras no encontrado.']);
        }

        // Obtener el producto asociado al código de barras
        $product = $barcodeEntry->product;

        if (!$product) {
            return response()->json(['error' => 'Producto no encontrado para el código de barras dado.']);
        }

        // Retornar los detalles del producto encontrado
        return response()->json(['product' => $product]);
    }

    public function updateProducts(Request $request)
    {
        $products = $request->products;

        foreach ($products as $product) {
            $model = Product::find($product['id']);
            if ($model) {
                $quantity = $product['stock'];
                $type = $quantity >= 0 ? 1 : 0;

                $model->update(['stock' => $model->stock + $quantity]);

                // Registro de historial de stock
                StockHistory::create([
                    'product_id' => $model->id,
                    'name' => $model->name,
                    'quantity' => abs($quantity),
                    'type' => $type,
                ]);
            }
        }
    }
}

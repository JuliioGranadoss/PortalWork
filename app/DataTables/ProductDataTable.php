<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;

class ProductDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {

        return (new EloquentDataTable($query))
            ->editColumn('status', function (Product $model) {
                return $model->getStatusLabel();
            })
            ->addColumn('categories', function (Product $model) {
                return '<ul><li>' . $model->categories->pluck('name')->implode('</li><li>') . '</li></ul>';
            })
            ->filterColumn('categories', function($query, $keyword) {
                $query->whereHas('categories', function($query) use ($keyword) {
                    $query->where('id', $keyword);
                });
            })
            ->addColumn('barcodes', function (Product $model) {
                return '<ul><li>' . $model->barcodes->pluck('code')->implode('</li><li>') . '</li></ul>';
            })
            ->addColumn('action', 'products.action')
            ->escapeColumns([])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product $model, Request $request): QueryBuilder
    {
        return $model->with('provider', 'categories', 'barcodes')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->parameters(["language" =>  ["url" => "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"]])
            ->responsive()
            ->setTableId('product-table')
            ->addTableClass('table-bordered w-100')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->lengthChange(false);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::computed('details')->title('')
                ->responsivePriority(0)->targets(-2)
                ->addClass('details-control')
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->defaultContent(''),
            Column::make('provider_id')->hidden(),
            Column::make('name')->responsivePriority(1)->addClass('column-name')->targets(0)->title('Nombre'),
            Column::make('description')->title('Descripción')->addClass('column-description'),
            Column::make('categories')->title('Categorías')->addClass('column-category'),
            Column::make('provider.name')->title('Proveedor')->addClass('column-provider'),
            Column::make('barcodes')->title('Código de Barras'),
            Column::make('stock')->title('Cantidad')->addClass('column-stock'),
            Column::make('status')->title('Estado')->addClass('column-status')->width(80),
            Column::computed('action')->title('Acciones')
                ->responsivePriority(2)
                ->targets(-1)
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center text-nowrap'),
        ];
    }
    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Product_' . date('YmdHis');
    }
}

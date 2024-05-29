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
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('status', function (Product $model) {
                return $model->getStatusLabel();
            })
            ->addColumn('categories', function (Product $model) {
                $categories = $model->categories->pluck('name');
                return $categories->isNotEmpty()
                    ? '<ul><li>' . $categories->implode('</li><li>') . '</li></ul>'
                    : 'N/A';
            })
            ->filterColumn('categories', function ($query, $keyword) {
                $query->whereHas('categories', function ($query) use ($keyword) {
                    $query->where('id', $keyword);
                });
            })
            ->addColumn('barcodes', function (Product $model) {
                $barcodes = $model->barcodes->pluck('code');
                return $barcodes->isNotEmpty()
                    ? '<ul><li>' . $barcodes->implode('</li><li>') . '</li></ul>'
                    : 'N/A';
            })
            ->addColumn('provider', function (Product $model) {
                return $model->provider ? $model->provider->name : 'N/A';
            })
            ->addColumn('action', 'products.action')
            ->escapeColumns([])
            ->setRowId('id');
    }

    public function query(Product $model, Request $request): QueryBuilder
    {
        return $model->with('provider', 'categories', 'barcodes')->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->parameters(["language" => ["url" => "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"]])
            ->responsive()
            ->setTableId('product-table')
            ->addTableClass('table-bordered w-100')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->lengthChange(false);
    }

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
            Column::make('provider')->title('Proveedor')->addClass('column-provider'),
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

    protected function filename(): string
    {
        return 'Product_' . date('YmdHis');
    }
}


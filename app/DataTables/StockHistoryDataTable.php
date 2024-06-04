<?php

namespace App\DataTables;

use App\Models\Product;
use App\Models\StockHistory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class StockHistoryDataTable extends DataTable
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
            ->addColumn('product_name', function (StockHistory $history) {
                return $history->product ? $history->product->name : 'N/A';
            })
            ->addColumn('quantity', function (StockHistory $history) {
                return $history->quantity;
            })
            ->addColumn('type', function (StockHistory $history) {
                return $history->getTypeLabel();
            })
            ->editColumn('created_at', function (StockHistory $history) {
                return date("d/m/Y H:i:s", $history->created_at);
            })
            ->editColumn('place_id', function (StockHistory $history) {
                return $history->place ? $history->place->name : 'N/A';
            })
            ->editColumn('personal_id', function (StockHistory $history) {
                return $history->personal ? $history->personal->name : 'N/A';
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $dates = explode(' to ', $keyword);
                if (count($dates) === 2) {
                    $startDate = date('Y-m-d 00:00:00', strtotime($dates[0]));
                    $endDate = date('Y-m-d 23:59:59', strtotime($dates[1]));
                    $query->where('created_at', '>=', $startDate)
                          ->where('created_at', '<=', $endDate);
                }
            })            
            ->escapeColumns([])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(StockHistory $model): QueryBuilder
    {
        return $model->newQuery();
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
            ->setTableId('stock-history-table')
            ->addTableClass('table-bordered w-100')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(3);
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
            Column::make('product_name')->title('Producto'),
            Column::make('place_id')->title('Lugar')->addClass('column-selectedPlace'),
            Column::make('personal_id')->title('Personal')->addClass('column-selectedPersonal'),
            Column::make('quantity')->title('Cantidad'),
            Column::make('type')->title('Tipo'),
            Column::make('created_at')->title('Fecha')->addClass('column-selectedDate')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'StockHistory_' . date('YmdHis');
    }
}

<?php

namespace App\DataTables;

use App\Models\StockMovement;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class StockMovementDataTable extends DataTable
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
            ->editColumn('place_id', function (StockMovement $movement) {
                return $movement->place ? $movement->place->name : 'N/A';
            })
            ->editColumn('personal_id', function (StockMovement $movement) {
                return $movement->personal ? $movement->personal->name . ' ' . $movement->personal->surname : 'N/A';
            })
            ->editColumn('created_at', function (StockMovement $movement) {
                return $movement->created_at instanceof \Carbon\Carbon ? $movement->created_at->format('d/m/Y H:i:s') : 'N/A';
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
            ->addColumn('action', 'stockmovement.action')
            ->escapeColumns([])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\StockMovement $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(StockMovement $model): QueryBuilder
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
            ->setTableId('stock-movement-table')
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
            Column::make('place_id')->title('Lugar')->addClass('column-selectedPlace'),
            Column::make('personal_id')->title('Personal')->addClass('column-selectedPersonal'),
            Column::make('created_at')->title('Fecha')->addClass('column-selectedDateRange'),
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
        return 'StockMovement_' . date('YmdHis');
    }
}

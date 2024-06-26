<?php

namespace App\DataTables;

use App\Models\WorkerOffer;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;

class WorkerOfferDataTable extends DataTable
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
            ->addColumn('offer', function (WorkerOffer $model) {
                return $model->offer->name;
            })
            ->addColumn('action', 'workeroffer.action')
            ->escapeColumns([])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\WorkerOffer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WorkerOffer $model, Request $request): QueryBuilder
    {
        return $model->where('worker_id', $request->id)->newQuery();
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
            ->setTableId('workeroffer-table')
            ->addTableClass('table-bordered w-100')
            ->columns($this->getColumns());
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            Column::computed('offer')->searchable()->title('Oferta'),
            Column::computed('action')->title('Acciones')
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
        return 'WorkerOffer_' . date('YmdHis');
    }
}

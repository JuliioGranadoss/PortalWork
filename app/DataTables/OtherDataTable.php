<?php

namespace App\DataTables;

use App\Models\Other;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;

class OtherDataTable extends DataTable
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
            ->addColumn('action', 'others.action')
            ->escapeColumns([])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Other $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Other $model, Request $request): QueryBuilder
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
            ->responsive()
            ->setTableId('other-table')
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
            Column::make('name')->responsivePriority(1)->targets(0)->title('Nombre'),
            Column::make('description')->title('Descripción'),
            Column::make('score')->title('Puntuación'),
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
        return 'Other_' . date('YmdHis');
    }
}

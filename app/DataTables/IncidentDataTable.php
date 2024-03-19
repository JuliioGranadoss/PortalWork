<?php

namespace App\DataTables;

use App\Models\Incident;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class IncidentDataTable extends DataTable
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
            ->addColumn('creator', function (Incident $model) {
                return ($model->creator) ? $model->creator->name : null;
            })
            ->filterColumn('creator', function ($query, $keyword) {
                $sql = "users.name like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            // ->addColumn('assigned', function (Incident $model) {
            //     return ($model->assigned) ? $model->assigned->name : __('No asignado');
            // })
            ->editColumn('status', function (Incident $model) {
                return $model->getStatusLabel();
            })
            ->editColumn('priority', function (Incident $model) {
                return $model->getPriorityLabel();
            })
            ->addColumn('action', 'incidents.action')
            ->escapeColumns([])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Incident $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Incident $model): QueryBuilder
    {
        return $model
        ->join('users', 'incidents.creator_id', '=', 'users.id')
        ->select('incidents.*', 'users.name')
        ->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->parameters(["language" =>  ["url" =>"//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"]])
            ->responsive()
            ->setTableId('incident-table')
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
            Column::make('priority')->title('Prioridad')->width(40),
            Column::make('title')->responsivePriority(1)->targets(0)->title('Título'),
            Column::make('description')->title('Descripción'),
            Column::make('creator')->title('Creador'),
            // Column::computed('assigned ')->title('Asignado a'),
            Column::make('status')->title('Estado')->width(80),
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
        return 'Incident_' . date('YmdHis');
    }
}

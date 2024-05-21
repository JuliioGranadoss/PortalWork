<?php

namespace App\DataTables;

use App\Models\Worker;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class WorkerDataTable extends DataTable
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
            ->editColumn('announcement', function (Worker $model) {
                return $model->announcement->format("d/m/Y");
            })
            ->editColumn('birth_date', function (Worker $model) {
                return $model->birth_date->format("d/m/Y");
            })
            ->editColumn('status', function (Worker $model) {
                return $model->getStatusLabel();
            })
            ->editColumn('driving_license_B', function (Worker $model) {
                return $model->getDrivingLicenseBLabel();
            })
            ->editColumn('driving_license_A', function (Worker $model) {
                return $model->getDrivingLicenseALabel();
            })
            ->addColumn('action', 'workers.action')
            ->escapeColumns([])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Worker $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Worker $model): QueryBuilder
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
            ->parameters(["language" =>  ["url" =>"//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"]])
            ->responsive()
            ->setTableId('worker-table')
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
            Column::make('announcement')->title('Convocatoria'),
            Column::make('name')->responsivePriority(1)->targets(0)->title('Nombre'),
            Column::make('surname')->title('Apellidos'),
            Column::make('dni')->title('DNI'),
            Column::make('email')->title('Email'),
            Column::make('birth_date')->title('Fecha de nacimiento'),
            Column::make('postal_code')->title('Código postal'),
            Column::make('province')->title('Provincia'),
            Column::make('phone')->title('Teléfono'),
            Column::make('phone2')->title('Segundo teléfono'),
            Column::make('driving_license_B')->title('Permiso B (turismo)')->width(80),
            Column::make('driving_license_A')->title('Permiso A (moto)')->width(80),
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
        return 'Worker_' . date('YmdHis');
    }
}

<?php

namespace App\DataTables;

use App\Models\StockPersonal;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class StockPersonalDataTable extends DataTable
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
            ->addColumn('name', function (StockPersonal $personal) {
                return $personal->name;
            })
            ->addColumn('surname', function (StockPersonal $personal) {
                return $personal->surname;
            })
            ->addColumn('dni', function (StockPersonal $personal) {
                return $personal->dni;
            })
            ->addColumn('phone', function (StockPersonal $personal) {
                return $personal->phone;
            })
            ->editColumn('status', function (StockPersonal $model) {
                return $model->getStatusLabel();
            })
            ->addColumn('action', 'stockpersonal.action')
            ->escapeColumns([])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\StockPersonal $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(StockPersonal $personal): QueryBuilder
    {
        return $personal->newQuery();
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
            ->setTableId('stock-personal-table')
            ->addTableClass('table-bordered w-100')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('name')->title('Nombre'),
            Column::make('surname')->title('Apellido'),
            Column::make('dni')->title('DNI'),
            Column::make('phone')->title('Teléfono'),
            Column::make('status')->title('Estado'),
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
        return 'StockPersonal_' . date('YmdHis');
    }
}

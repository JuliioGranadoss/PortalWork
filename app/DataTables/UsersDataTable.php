<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('name', function (User $model) {
                return $model->name;
            })
            ->editColumn('created_at', function (User $model) {
                return $model->created_at->format('d/m/Y');
            }) 
            ->editColumn('role', function (User $model) {
                return $model->getRoleLabel($model->getRole());
            })
            ->addColumn('action', 'users.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->parameters(["language" =>  ["url" =>"//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"]])
            ->responsive()
            ->setTableId('users-table')
            ->addTableClass('table-bordered w-100')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->lengthChange(false);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
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
            Column::make('email')->title('Email'),
            Column::make('role')->title('Role'),
            Column::make('created_at')->title('Creado'),
            Column::computed('action')->title('Acciones')
                ->responsivePriority(2)
                ->targets(-1)
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center text-nowrap'),
        ];
    }
}

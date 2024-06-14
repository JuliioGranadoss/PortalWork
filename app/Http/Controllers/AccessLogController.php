<?php

namespace App\Http\Controllers;

use App\DataTables\AccessLogDataTable;

class AccessLogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the datatable.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(AccessLogDataTable $dataTable)
    {
        return $dataTable->render('access-log.index');
    }

}

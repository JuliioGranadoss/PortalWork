<?php

namespace App\Http\Controllers;

use App\DataTables\StockHistoryDataTable;

class StockHistoryController extends Controller
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
    public function index(StockHistoryDataTable $dataTable)
    {
        return $dataTable->render('stockhistory.index');
    }
}

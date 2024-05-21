<?php

namespace App\Http\Controllers;

use App\DataTables\StockHistoryDataTable;
use Illuminate\Http\Request;
use App\Models\StockHistory;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StockHistoryExport;

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

<?php

namespace App\Http\Controllers;

use App\DataTables\ContactDataTable;
use Illuminate\Http\Request;
use App\Models\Contact;
use Maatwebsite\Excel\Facades\Excel;

class ContactController extends Controller
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
    public function index(ContactDataTable $dataTable)
    {
        return $dataTable->render('contact.index');
    }
}

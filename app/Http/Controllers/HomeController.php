<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $count = Invoice::count();

        $invoicesPaid = Invoice::where('value_status', 1)->count();
        $resutlPaid = ($invoicesPaid / $count) * 100;

        $invoicesUnpaid = Invoice::where('value_status', 2)->count();
        $resutlUnPaid = ($invoicesUnpaid / $count) * 100;

        $invoicesPartiall = Invoice::where('value_status', 3)->count();
        $resutlPartiall = ($invoicesPartiall / $count) * 100;
        return view('home', compact('resutlPaid', 'resutlUnPaid', 'resutlPartiall'));
    }
}

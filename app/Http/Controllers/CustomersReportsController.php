<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Section;
use Illuminate\Http\Request;

class CustomersReportsController extends Controller
{
    public function index() 
    {
        $sections = Section::all();
        return view('reports.customers_reports', compact('sections'));
    }

    public function search_customers(Request $request) 
    {
        if ($request->section && $request->product && $request->start_at == '' && $request->end_at == '') {

            if ($request->product === 'all') {
                $invoices = Invoice::all()->where('section_id', $request->section);
                $sections = Section::all();
                return view('reports.customers_reports', compact('invoices', 'sections'))->withDetails($invoices);
            }
            $sections = Section::all();
            $invoices = Invoice::select('*')->where('section_id', $request->section)->where('product', $request->product)->get();
            return view('reports.customers_reports', compact('sections'))->withDetails($invoices);
        // if select date
        } else {
            $start_at = date($request->start_at);
            $end_at = date($request->end_at);

            $sections = Section::all();
            $invoices = Invoice::select('*')->whereBetween('invoice_date', [$start_at, $end_at])->where('section_id', '=', $request->section)->get();
            return view('reports.customers_reports', compact('start_at', 'end_at', 'sections'))->withDetails($invoices);
        }
    }
}

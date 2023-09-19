<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoicesReportsController extends Controller
{
    public function index()
    {
        return view('reports.invoices_reports');
    }

    public function search_invoices(Request $request)
    {
        $radio = $request->rdio;

        // if searsh by invoice type
        if ($radio == 1) {
            // if don't select date
            if ($request->type && $request->start_at == '' && $request->end_at == '') {
                $invoices = Invoice::select('*')->where('status', '=', $request->type)->get();
                $type = $request->type;
                return view('reports.invoices_reports', compact('type'))->withDetails($invoices);
            // if select date
            } else {
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;

                $invoices = Invoice::select('*')->whereBetween('invoice_date', [$start_at, $end_at])->where('status', '=', $request->type)->get();
                return view('reports.invoices_reports', compact('start_at', 'end_at', 'type'))->withDetails($invoices);
            }

        // if searsh by invoice number
        } else {
            $invoices = Invoice::select('*')->where('invoice_number', $request->invoice_number)->get();
            return view('reports.invoices_reports')->withDetails($invoices);
        }
    }
}
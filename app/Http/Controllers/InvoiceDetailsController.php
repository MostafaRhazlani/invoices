<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Invoice_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice_details $invoice_details)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // return $id;
        $invoices = Invoice::where('id', $id)->first();
        return view('invoices.edit_payment_status', compact('invoices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        // return $request;
        $invoices = Invoice::findOrFail($id);

        if($request->status === 'مدفوعة') {
            $invoices->update([
                'value_status' => 1,
                'status' => $request->status,
                'payment_date' => $request->payment_date
            ]);

            Invoice_details::create([
                'id_invoice' => $request->id_invoice,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->section,
                'status' => $request->status,
                'value_status' => 1,
                'payment_date' => $request->payment_date,
                'note' => $request->note,
                'user' => Auth::user()->name,
            ]);
        } else {
            $invoices->update([
                'value_status' => 3,
                'status' => $request->status,
                'payment_date' => $request->payment_date
            ]);

            Invoice_details::create([
                'id_invoice' => $request->id_invoice,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->section,
                'status' => $request->status,
                'value_status' => 3,
                'payment_date' => $request->payment_date,
                'note' => $request->note,
                'user' => Auth::user()->name,
            ]);

        }
            session()->flash('Edit_payment');
            return redirect('/invoices');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice_details $invoice_details)
    {
        //
    }
}

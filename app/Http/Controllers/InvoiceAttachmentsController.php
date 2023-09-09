<?php

namespace App\Http\Controllers;

use App\Models\Invoice_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class InvoiceAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice_attachments $invoice_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $invoives = Invoice_attachments::findOrFail($request->id_file);
        $invoives->delete();
        Storage::disk('public_path')->delete($request->invoice_number . '/' . $request->file_name);
        
        session()->flash('Delete','تم حذف المرفق بنجاح');
        return back();
    }

    public function openFile($invoice_number, $file_name)
    {
        $pathToFile = public_path('Attachments/' . $invoice_number . '/' . $file_name);
        if (file_exists($pathToFile)) {
            return Response::file($pathToFile);
        }
    }

    public function getFile($invoice_number, $file_name)
    {
        $pathToFile = public_path('Attachments/' . $invoice_number . '/' . $file_name);
        if (file_exists($pathToFile)) {
            return Response::download($pathToFile);
        }
    }
}

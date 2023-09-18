<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoicesArchiveController extends Controller
{
    function __construct()
    {
      $this->middleware('permission:ارشيف الفواتير', ['only' => ['index']]);
    //   $this->middleware('permission:اضافة فاتورة', ['only' => ['create','store']]);
    //   $this->middleware('permission:تعديل الفاتورة', ['only' => ['edit','update']]);
    //   $this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoicesArchive = Invoice::onlyTrashed()->get();
        return view('invoices.invoices_archive', compact('invoicesArchive'));
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
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id_invoice;
        $invoice = Invoice::withTrashed()->where('id', $id)->restore();

        session()->flash('Restore');
        return redirect('/invoices');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id_invoice;

        $destroy_archives = Invoice::withTrashed()->where('id', $id);
        $destroy_archives->forceDelete();

        session()->flash('Delete');
        return redirect('/invoices_archive');
    }
}

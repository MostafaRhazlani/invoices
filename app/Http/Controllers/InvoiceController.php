<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceExport;
use App\Models\Invoice;
use App\Models\Invoice_attachments;
use App\Models\Invoice_details;
use App\Models\Section;
use App\Models\User;
use App\Notifications\EmailInvoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
    function __construct()
    {
      $this->middleware('permission:قائمة الفواتير', ['only' => ['index']]);
      $this->middleware('permission:الفواتير المدفوعة', ['only' => ['invoices_paid']]);
      $this->middleware('permission:الفواتير الغير مدفوعة', ['only' => ['invoices_unpaid']]);
      $this->middleware('permission:الفواتير المدفوعة جزئيا', ['only' => ['invoices_partiall']]);
      $this->middleware('permission:طباعةالفاتورة', ['only' => ['print_invoice']]);
      $this->middleware('permission:تصدير EXCEL', ['only' => ['export']]);
      $this->middleware('permission:اضافة فاتورة', ['only' => ['create','store']]);
      $this->middleware('permission:تعديل الفاتورة', ['only' => ['edit','update']]);
      $this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $sections = Section::all(); 
        $invoices = Invoice::all(); 
        return view('invoices.invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();
        return view('invoices.add_invoice', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        $validateData = $request->validate([
            'invoice_number' => 'required|max:255',
            'due_date' => 'required',
            'section' => 'required',
            'amount_collection' => 'required',
            'amount_commission' => 'required',
            'discount' => 'required',
            'rate_vat' => 'required',
        ],[
            'invoice_number.required' => 'يرجى ادخال اسم الفاتورة',
            'due_date.required' => 'يرجى تحديد تاريخ الاستحقاق',
            'section.required' => 'يرجى تحديد القسم',
            'amount_collection.required' => 'يرجى ادخال مبلغ التحصيل',
            'amount_commission.required' => 'يرجى ادخال مبلغ العمولة',
            'discount.required' => 'يرجى ادخال الخصم',
            'rate_vat.required' => 'يرجى تحديد نسبة ضريبة القيمة المضافة',
        ]);

        Invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'section_id' => $request->section,
            'product' => $request->product,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'rate_vat' => $request->rate_vat,
            'value_vat' => $request->value_vat,
            'total' => $request->total,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            
        ]);

        $invoice_id = Invoice::latest()->first()->id;

        Invoice_details::create([
            'id_invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->section,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user' => Auth::user()->name,
        ]);

        if ($request->hasFile('pic')) {

            $this->validate($request, [
                'pic' => 'required|mimes:pdf,png,jpg,jpeg|max:1000',
            ],[
                'pic.mimes' => 'خطأ : صيغة الملف غير مدعومة',
            ]);

            $invoice_id = Invoice::latest()->first()->id;
            $image = $request->file('pic');
            $fileName = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new Invoice_attachments();
            $attachments->file_name = $fileName;
            $attachments->invoice_number = $invoice_number;
            $attachments->created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;

            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/'. $invoice_number), $imageName);

        }
            $user = User::first();
            $user->notify(new EmailInvoices($invoice_id));
            session()->flash('Add');
            return redirect('/invoices');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoices = Invoice::where('id', $id)->first();
        $details = Invoice_details::with('invoice')->where('id_invoice', $id)->get();
        $invoicesAttachments = Invoice_attachments::where('invoice_id', $id)->get();
        
        return view('invoices.invoicesDetails', compact('invoices', 'details', 'invoicesAttachments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoices = Invoice::where('id', $id)->first();
        $sections = Section::all();

        return view('invoices.edit_invoice', compact('invoices', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $invoice = Invoice::findOrFail($request->invoice_id);
        $invoice->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->section,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'note' => $request->note,
        ]);

        session()->flash('Edit');
        return redirect('/invoices');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id_page = $request->id_page;
        $id = $request->id_invoice;
        $invoice = Invoice::where('id', $id)->first();
        $delete_file = Invoice_attachments::where('invoice_id', $id)->first();

        if(!$id_page == 2) {
            if (!empty($delete_file->invoice_number)) {
                Storage::disk('public_path')->deleteDirectory($delete_file->invoice_number);
            }

            $invoice->forceDelete();
            session()->flash('Delete');
            return redirect('/invoices');
        } else {

            $invoice->Delete();
            session()->flash('Archive');
            return redirect('/invoices_archive');
        }

    }

    public function getProducts($id)
    {
        $products = DB::table('products')->where('section_id', $id)->pluck('product_name', 'id');
        return json_encode($products);
    }

    public function invoices_paid()
    {
        $invoices_paid = Invoice::where('value_status', 1)->get();
        return view('invoices.invoices_paid', compact('invoices_paid'));
    }

    public function invoices_unpaid()
    {
        $invoices_unpaid = Invoice::where('value_status', 2)->get();
        return view('invoices.invoices_unpaid', compact('invoices_unpaid'));
    }

    public function invoices_partiall()
    {
        $invoices_partiall = Invoice::where('value_status', 3)->get();
        return view('invoices.invoices_partiall', compact('invoices_partiall'));
    }

    public function print_invoice(Request $request)
    {
        $id = $request->id;
        $print_invoice = Invoice::where('id', $id)->first();
        return view('invoices.print_invoices', compact('print_invoice'));
    }

    // Export invoices
    public function export() 
    {
        return Excel::download(new InvoiceExport, 'Invoices.xlsx');
    }
}

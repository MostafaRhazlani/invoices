<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:المنتجات', ['only' => ['index']]);
        $this->middleware('permission:اضافة منتج', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل منتج', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف منتج', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::all();
        $products = Product::all();
        return view('products.products', compact('sections', 'products'));
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
        return $request;
        $validateData = $request->validate([
            'product_name' => 'required|max:255',
            'section_id' => 'required',
        ],[
            'product_name.required' => 'يرجى ادخال اسم المنتج',
            'section_id.required' => 'يرجى تحديد اسم المنتج',
        ]);

        Product::create([
            'product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description,
        ]);

        session()->flash('Add', 'تم اضافة المنتج بنجاح');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'product_name' => 'required|max:255|unique:products,product_name,'. $request->pro_id,
        ],[
            'product_name.required' => 'يرجى ادخال اسم المنتج',
            'product_name.unique' => 'اسم المنتج مسجل مسبقا',
        ]);

        $id = Section::where('section_name', $request->section_name)->first()->id;

        $products = Product::findOrFail($request->pro_id);

        $products->update([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $id,
        ]);

        session()->flash('Edit','تم تعديل المنتج بنجاج');
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->pro_id;

        Product::findOrFail($id)->delete();
        session()->flash('Delete','تم حذف المنتج بنجاح');
        return redirect('/products');
    }
}

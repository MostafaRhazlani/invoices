<?php

namespace App\Http\Controllers;

use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    function __construct()
  {
    $this->middleware('permission:الاقسام', ['only' => ['index']]);
    // $this->middleware('permission:اضافة صلاحية', ['only' => ['create','store']]);
    // $this->middleware('permission:تعديل صلاحية', ['only' => ['edit','update']]);
    // $this->middleware('permission:حذف صلاحية', ['only' => ['destroy']]);
  }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::all();
        return view('sections.sections', compact('sections'));
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

        $validatedData = $request->validate([
            'section_name' => 'required|unique:sections|max:255',
        ],[
            'section_name.required' => 'يرجى ادخال اسم القسم',
            'section_name.unique' => 'اسم القسم مسجل مسبقا',
        ]);

        Section::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'created_by' => Auth::user()->name,
        ]);
        
        session()->flash('Add', 'تم اضافة القسم بنجاح');
        return redirect('/sections');
    }

    /**
     * Display the specified resource.
     */
    public function show(section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;

        $this->validate($request, [
            'section_name' => 'required|max:255|unique:sections,section_name,'. $id,
        ],[
            'section_name.required' => 'يرجى ادخال اسم القسم',
            'section_name.unique' => 'اسم القسم مسجل مسبقا',
        ]);

        $sections = Section::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);

        session()->flash('Edit','تم تعديل القسم بنجاج');
        return redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Request $request)
    {
        $id = $request->id;

        Section::find($id)->delete();
        session()->flash('Delete','تم حذف القسم بنجاح');
        return redirect('/sections');
    }
}

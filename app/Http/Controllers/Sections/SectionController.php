<?php

namespace App\Http\Controllers\Sections;
use App\Http\Controllers\Controller;

use App\Models\Section;
use App\Models\Product;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();
        return view('pages.sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $sections = new Section();
            $sections->name = ['en' => $request->name_en, 'ar' => $request->name];
            $sections->notes = $request->notes;
            $sections->save();
            return redirect()->route('sections.index');
        }

        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $sections = Section::findOrFail($request->id);
            $sections->update([
            $sections->name = ['ar' => $request->name, 'en' => $request->name_en],
            $sections->notes = $request->notes,
          ]);
          return redirect()->route('sections.index');
        }
        catch(\Exception $e) {
          return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $products = Product::where('section_id',$request->id)->pluck('section_id');

        if($products->count() == 0){
            $sections = Section::findOrFail($request->id)->delete();
            return redirect()->route('sections.index');
        }
        else{
            return redirect()->route('sections.index');
        }
    }
}

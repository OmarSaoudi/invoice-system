<?php

namespace App\Http\Controllers\Products;
use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        $sections = Section::all();
        return view('pages.products.index', compact('products', 'sections'));
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

            $products = new Product();
            $products->name = ['en' => $request->name_en, 'ar' => $request->name];
            $products->section_id = $request->section_id;
            $products->save();

            return redirect()->route('products.index');
        }

        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {

            $products = Product::findOrFail($request->id);
            $products->update([

                $products->name = ['ar' => $request->name, 'en' => $request->name_en],
                $products->section_id = $request->section_id,
            ]);

            return redirect()->route('products.index');
        }

        catch(\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $products = Product::findOrFail($request->id)->delete();
        return redirect()->route('products.index');
    }

    public function delete_all_p(Request $request)
    {
        $delete_all_id = explode(",", $request->delete_all_id);
        Product::whereIn('id', $delete_all_id)->delete();
        return redirect()->route('products.index');
    }

    public function Filter_Products_Section(Request $request)
    {
        $sections = Section::all();
        $Search = Product::select('*')->where('section_id','=',$request->section_id)->get();
        return view('pages.products.index',compact('sections'))->withDetails($Search);
    }
}

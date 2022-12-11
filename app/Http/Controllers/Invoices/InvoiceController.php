<?php

namespace App\Http\Controllers\Invoices;
use App\Http\Controllers\Controller;

use App\Models\Invoice;
use App\Models\Section;
use App\Models\Product;
use App\Models\InvoiceDetails;
use App\Models\InvoiceAttachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::all();
        return view('pages.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::all();
        return view('pages.invoices.create', compact('sections'));
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
            Invoice::create([
                'invoice_number' => $request->invoice_number,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'product_id' => $request->product_id,
                'section_id' => $request->section_id,
                'amount_collection' => $request->amount_collection,
                'amount_commission' => $request->amount_commission,
                'discount' => $request->discount,
                'value_vat' => $request->value_vat,
                'rate_vat' => $request->rate_vat,
                'total' => $request->total,
                'status' => 'غير مدفوعة',
                'value_status' => 2,
                'note' => $request->note,
                'payment_date' => $request->payment_date,
            ]);

                $id_invoice = Invoice::latest()->first()->id; // Give me The Last id for invoices saves
                InvoiceDetails::create([
                'id_invoice' => $id_invoice,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product_id,
                'section' => $request->section_id,
                'status' => 'غير مدفوعة',
                'value_status' => 2,
                'note' => $request->note,
                'created_by' => (Auth::user()->name),
            ]);

            if ($request->hasFile('photo'))
            {
                $this->validate($request, ['photo' => 'mimes:mp4,mp3,txt,zip,pdf,jpeg,jpg,png,gif,ppt,pptx,doc,docx,xls,xlsx|required|max:10000']);
                $invoice_id = Invoice::latest()->first()->id; // Give me The Last id for invoices saves
                $image = $request->file('photo');
                $file_name = $image->getClientOriginalName();
                $invoice_number = $request->invoice_number;
                $attachments = new InvoiceAttachments();
                $attachments->invoice_id = $invoice_id;
                $attachments->file_name = $file_name;
                $attachments->invoice_number = $invoice_number;
                $attachments->created_by = Auth::user()->name;
                $attachments->save();

                // move photo
                $imageName = $request->photo->getClientOriginalName();
                $request->photo->move(public_path('Attachments/' . $invoice_number), $imageName);
            }
            return redirect()->route('invoices.index');
        }
        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices = Invoice::where('id',$id)->first();
        $details  = InvoiceDetails::where('id_invoice',$id)->get();
        $attachments  = InvoiceAttachments::where('invoice_id',$id)->get();
        return view('pages.invoices.details_invoice',compact('invoices','details','attachments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sections = Section::all();
        $invoices = Invoice::where('id', $id)->first();
        return view('pages.invoices.edit', compact('sections', 'invoices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $invoices = Invoice::findOrFail($request->invoice_id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'section_id' => $request->section_id,
            'product_id' => $request->product_id,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'note' => $request->note,
        ]);
        $invoicedetails = InvoiceDetails::findOrFail($request->invoice_id);
        $invoicedetails->update([
            'invoice_number' => $request->invoice_number,
            'product' => $request->product_id,
            'section' => $request->section_id,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'created_by' => (Auth::user()->name),
        ]);
        return redirect()->route('invoices.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $invoices = Invoice::where('id', $id)->first();
        $attachments = InvoiceAttachments::where('invoice_id', $id)->first();
        $id_page =$request->id_page;


        if (!$id_page==2) {
            if (!empty($attachments->invoice_number)) {
               Storage::disk('public_uploads')->deleteDirectory($attachments->invoice_number);
            }

            $invoices->forceDelete();
            return redirect()->route('invoices.index');
        }
        else {
            $invoices->delete();
            return redirect()->route('archives.index');
        }
    }


    public function getproducts($id)
    {
        $list_products = Product::where("section_id", $id)->pluck("name", "id");
        return $list_products;
    }

    public function invoiceattachmentsadd(Request $request)
    {
            $image = $request->file('file_name');
            $file_name = $image->getClientOriginalName();
            $attachments =  new InvoiceAttachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $request->invoice_number;
            $attachments->invoice_id = $request->invoice_id;
            $attachments->created_by = Auth::user()->name;
            $attachments->save();
            // move photo
            $imageName = $request->file_name->getClientOriginalName();
            $request->file_name->move(public_path('Attachments/'. $request->invoice_number), $imageName);
            return back();
    }

    public function open_file($invoice_number,$file_name)
    {
        return response()->file(public_path('Attachments/'.$invoice_number.'/'.$file_name));
    }

    public function download_file($invoice_number,$file_name)
    {
        return response()->download(public_path('Attachments/'.$invoice_number.'/'.$file_name));
    }

    public function delete_file(Request $request)
    {
        $invoices = InvoiceAttachments::findOrFail($request->id);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        return redirect()->back();
    }

    public function print_invoice($id)
    {
        $invoices = Invoice::where('id', $id)->first();
        return view('pages.invoices.print_invoice', compact('invoices'));
    }
}

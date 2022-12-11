<?php

namespace App\Http\Controllers\Invoices;
use App\Http\Controllers\Controller;

use App\Models\Invoice;
use App\Models\InvoiceAttachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchiveController extends Controller
{
    public function index()
    {
        $invoices = Invoice::onlyTrashed()->get();
        return view('pages.invoices.archive', compact('invoices'));
    }

    public function update(Request $request)
    {
         $id = $request->id;
         $flight = Invoice::withTrashed()->where('id', $id)->restore();
         return redirect()->route('invoices.index');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $attachments = InvoiceAttachments::where('invoice_id', $id)->first();
        if (!empty($attachments->invoice_number)) {
            Storage::disk('public_uploads')->deleteDirectory($attachments->invoice_number);
        }
         $invoices = Invoice::withTrashed()->where('id',$request->id)->first();
         $invoices->forceDelete();
         return redirect()->back();
    }
}

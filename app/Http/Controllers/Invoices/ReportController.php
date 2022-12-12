<?php

namespace App\Http\Controllers\Invoices;
use App\Http\Controllers\Controller;

use App\Models\Invoice;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('pages.invoices.reports');
    }

    public function search_invoices(Request $request){

        $radio = $request->radio;
        // في حالة البحث بنوع الفاتورة
        if ($radio == 1) {
            // في حالة عدم تحديد تاريخ
            if ($request->type && $request->start_at == '' && $request->end_at == '')
            {

               $invoices = Invoice::select('*')->where('status','=',$request->type)->get();
               $type = $request->type;
               return view('pages.invoices.reports', compact('type'))->withDetails($invoices);
            }

            // في حالة تحديد تاريخ استحقاق
            else
            {
               $start_at = date($request->start_at);
               $end_at = date($request->end_at);
               $type = $request->type;
               $invoices = Invoice::whereBetween('invoice_date',[$start_at,$end_at])->where('status','=',$request->type)->get();
               return view('pages.invoices.reports',compact('type','start_at','end_at'))->withDetails($invoices);
            }
        }

        //====================================================================

        // في البحث برقم الفاتورة
        else {
            $invoices = Invoice::select('*')->where('invoice_number','=',$request->invoice_number)->get();
            return view('pages.invoices.reports')->withDetails($invoices);
        }
    }
}

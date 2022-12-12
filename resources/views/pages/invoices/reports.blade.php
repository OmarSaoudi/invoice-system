@extends('layouts.master')

@section('title')
    Invoices Reports
@stop

@section('css')

@endsection

@section('content')

<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
     <h1>
       Invoices
     </h1>
     <ol class="breadcrumb">
       <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
       <li><a href="{{ route('invoices.index') }}">Invoices</a></li>
       <li class="active">Invoices Reports</li>
     </ol>
   </section>

   <section class="content">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Invoices Reports</h3>
        </div>
        <div class="box-body">
            <form action="{{ url('search_invoices') }}" method="post" role="search" autocomplete="off">
                {{ csrf_field() }}

                <!-- radio -->
                <div class="form-group">
                    <div class="radio">
                      <label>
                        <input type="radio" name="radio" value="1" id="type_div" checked>
                                Search by invoice type
                      </label>
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" name="radio" value="2">
                                Search by invoice number
                      </label>
                    </div>
                </div>

                {{-- 3 --}}
                <div class="row">
                    <div class="col-md-4" id="type">
                      <div class="form-group">
                         <label>Select the type of invoice</label>
                         <select class="form-control" name="type" required>
                            <option value="{{ $type ?? 'Select the type of invoice' }}" selected>{{ $type ?? 'Select the type of invoice' }}</option>
                            <option value="Paid">Paid Invoices</option>
                            <option value="Unpaid">Unpaid Invoices</option>
                            <option value="Partially paid">Partially Paid Invoices</option>
                         </select>
                      </div>
                    </div>
                    <div class="col-md-4" id="invoice_number">
                        <div class="form-group">
                           <label>Search by invoice number</label>
                           <input type="text" id="invoice_number" name="invoice_number"class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4" id="start_at">
                        <label>From the date of</label>
                        <input type="date" class="form-control fc-datepicker" value="{{ $start_at ?? '' }}" name="start_at">
                    </div>
                    <div class="col-md-4" id="end_at">
                        <label>To date</label>
                        <input type="date" class="form-control fc-datepicker" value="{{ $end_at ?? '' }}" name="end_at">
                    </div>
                </div>
                {{-- End 3 --}}
                <br><br>
                <div class="form-group" style="text-align:center">
                    <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Saving Data</button>
                    <a href="{{ route('invoices.index') }}" class="btn btn-warning"><i class="fa fa-undo"></i> Back</a>
                </div>
            </form>
        </div>
        <div class="box-body">
            @if (isset($details))
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>#</th>
                <th>Invoice Number</th>
                <th>Invoice Date</th>
                <th>Due Date</th>
                <th>Section Name</th>
                <th>Product Name</th>
                <th>Discount</th>
                <th>Rate Vat</th>
                <th>Value Vat</th>
                <th>Total</th>
                <th>Status</th>
                <th>Note</th>
              </tr>
              </thead>
              <tbody>
              @foreach ($details as $invoice)
              <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $invoice->invoice_number }}</td>
                <td>{{ $invoice->invoice_date }}</td>
                <td>{{ $invoice->due_date }}</td>
                <td>{{ $invoice->section->name }}</a></td>
                <td>{{ $invoice->product->name }}</td>
                <td>{{ $invoice->discount }}</td>
                <td>{{ $invoice->rate_vat }}</td>
                <td>{{ $invoice->value_vat }}</td>
                <td>{{ $invoice->total }}</td>
                <td>
                    @if($invoice->value_status == 1)
                      <span class="text-success">{{ $invoice->status }}</span>
                    @elseif($invoice->value_status == 2)
                      <span class="text-danger">{{ $invoice->status }}</span>
                    @else
                      <span class="text-warning">{{ $invoice->status }}</span>
                    @endif
                </td>
                <td>{{ $invoice->note }}</td>
              </tr>
              @endforeach
              </tbody>
              <tfoot>
              <tr>
                <th>#</th>
                <th>Invoice Number</th>
                <th>Invoice Date</th>
                <th>Due Date</th>
                <th>Section Name</th>
                <th>Product Name</th>
                <th>Discount</th>
                <th>Rate Vat</th>
                <th>Value Vat</th>
                <th>Total</th>
                <th>Status</th>
                <th>Note</th>
              </tr>
              </tfoot>
            </table>
            @endif
        </div>
    </div>
   </section>

</div>

@endsection

@section('scripts')
<script>
    var date = $('.fc-datepicker').datepicker({
        dateFormat: 'yy-mm-dd'
    }).val();
</script>
<script>
    $(document).ready(function() {
        $('#invoice_number').hide();
        $('input[type="radio"]').click(function() {
            if ($(this).attr('id') == 'type_div') {
                $('#invoice_number').hide();
                $('#type').show();
                $('#start_at').show();
                $('#end_at').show();
            } else {
                $('#invoice_number').show();
                $('#type').hide();
                $('#start_at').hide();
                $('#end_at').hide();
            }
        });
    });
</script>
@endsection

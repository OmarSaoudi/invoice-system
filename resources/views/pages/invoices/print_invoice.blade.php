@extends('layouts.master')

@section('title')
      Invoices | Print Invoice
@stop

@section('css')
<style>
    @media print {
        #print_Button {
            display: none;
        }
    }
</style>
@endsection

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
        Invoice
        <small>Invoice Print Preview</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ route('invoices.index') }}">Invoices</a></li>
      <li class="active">Invoice Print Preview</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="invoice" id="print">
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-globe"></i> Collection Invoice
        </h2>
      </div>
    </div>
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        From
        <address>
          <strong>Admin, Inc.</strong><br>
          795 Folsom Ave, Suite 600<br>
          San Francisco, CA 94107<br>
          Phone: (804) 123-5432<br>
          Email: info@almasaeedstudio.com
        </address>
      </div>
      <div class="col-sm-4 invoice-col">
        To
        <address>
          <strong>John Doe</strong><br>
          795 Folsom Ave, Suite 600<br>
          San Francisco, CA 94107<br>
          Phone: (555) 539-1037<br>
          Email: john.doe@example.com
        </address>
      </div>
      <div class="col-sm-4 invoice-col">
        <b>Invoice Information</b><br>
        <br>
        <b>Invoice Number :</b> {{ $invoices->invoice_number }}<br>
        <b>Invoice Date :</b> {{ $invoices->invoice_date }}<br>
        <b>Due Date :</b> {{ $invoices->due_date }}<br>
        <b>Section Name :</b> {{ $invoices->section->name }}<br>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-bordered">
          <thead>
          <tr>
            <th>#</th>
            <th>Product Name</th>
            <th>Amount Collection</th>
            <th>Amount Commission</th>
            <th>Total</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td>1</td>
            <td>{{ $invoices->product->name }}</td>
            <td>{{ number_format($invoices->amount_collection , 2) }}</td>
            <td>{{ number_format($invoices->amount_commission , 2) }}</td>
            @php
              $total_1 = $invoices->amount_collection + $invoices->amount_commission ;
            @endphp
            <td>{{ number_format($total_1, 2) }}</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-6">
      </div>
      <div class="col-xs-6">

        <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
              <th style="width:50%">Total :</th>
              <td>{{ number_format($total_1, 2) }}</td>
            </tr>
            <tr>
              <th>Tax Rate ({{ $invoices->rate_vat }}) :</th>
              <td>{{ $invoices->rate_vat }}</td>
            </tr>
            <tr>
              <th>Discount Value :</th>
              <td>{{ number_format($invoices->discount, 2) }}</td>
            </tr>
            <tr>
              <th>Total Including Tax :</th>
              <td class="text-primary"><h4><b>{{ number_format($invoices->total , 2) }}</b></h1></td>
            </tr>
          </table>
        </div>
      </div>
    </div>

    <div class="row no-print">
      <div class="col-xs-12">
        <a href="{{ route('invoices.index') }}" class="btn btn-warning"><i class="fa fa-undo"></i> Back</a>
        <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;" id="print_Button" onclick="printDiv()">
              <i class="fa fa-print"></i> &nbsp;Print
        </button>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>

@endsection


@section('scripts')
<script type="text/javascript">
    function printDiv() {
        var printContents = document.getElementById('print').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>
@endsection

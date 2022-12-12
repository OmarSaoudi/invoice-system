@extends('layouts.master')

@section('title')
      Unpaid Invoices
@stop

@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
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
      <li><a href="{{ route('invoices.index') }}"><i class="fa fa-file-text-o"></i> Invoices</a></li>
      <li class="active">Unpaid Invoices</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
             <h3 class="box-title">Unpaid Invoices List <small>{{ $invoices->count() }}</small></h3>
             <br><br>
          </div>
          <div class="box-body">
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
              @foreach($invoices as $invoice)
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
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>

@endsection


@section('scripts')
<script src="{{ URL::asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
  $(function () {
    $('#example1').DataTable()
  })
</script>
@endsection

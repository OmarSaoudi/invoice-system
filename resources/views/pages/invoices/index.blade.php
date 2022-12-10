@extends('layouts.master')

@section('title')
    Invoices
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
      <li class="active">Invoices</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
             <h3 class="box-title">Invoices List <small>{{ $invoices->count() }}</small></h3>
             <br><br>
             <a href="invoices/create" class="btn btn-success"><i class="fa fa-plus"></i> Add</a>
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
                <th>Operation</th>
              </tr>
              </thead>
              <tbody>
              @foreach($invoices as $invoice)
              <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $invoice->invoice_number }}</td>
                <td>{{ $invoice->invoice_date }}</td>
                <td>{{ $invoice->due_date }}</td>
                <td><a href="{{ url('InvoicesDetails') }}/{{ $invoice->id }}">{{ $invoice->section->name }}</a></td>
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
                <td>
                  <a href="{{ route('invoices.edit',$invoice->id) }}" class="btn btn-primary btn-sm" role="button" aria-pressed="true"><i class="fa fa-edit"></i></a>
                  <a class="btn btn-danger btn-sm" data-toggle="modal" data-id="{{ $invoice->id }}" data-invoice_number="{{ $invoice->invoice_number }}" data-target="#delete_invoice"><i class="fa fa-trash"></i></a>
                </td>
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
                <th>Operation</th>
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

<!-- Delete -->
<div class="modal fade" id="delete_invoice">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
            <h4 class="modal-title">Delete Invoice</h4>
      </div>
      <div class="modal-body">
        <form action="invoices/destroy" method="post">
                      {{ method_field('delete') }}
                      {{ csrf_field() }}
                  <div class="modal-body">
                      <p>Are sure of the deleting process ?</p><br>
                      <input type="hidden" name="id" id="id" value="">
                      <input class="form-control" name="invoice_number" id="invoice_number" type="text" readonly>
                  </div>

                  <div class="modal-footer">
                       <button type="submit" class="btn btn-danger">Save changes</button>
                       <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                  </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- End Delete -->

@endsection


@section('scripts')
<script src="{{ URL::asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
  $(function () {
    $('#example1').DataTable()
  })
</script>
<script>
  $('#delete_invoice').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget)
      var id = button.data('id')
      var invoice_number = button.data('invoice_number')
      var modal = $(this)
      modal.find('.modal-body #id').val(id);
      modal.find('.modal-body #invoice_number').val(invoice_number);
  })
</script>
@endsection

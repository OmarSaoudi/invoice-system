@extends('layouts.master')

@section('title')
     Invoices Details
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
       <li class="active">Invoices Details</li>
    </ol>
   </section>

   <section class="content">
    <div class="row">
      <div class="col-xs-12">
       <div class="box">
        <div class="box-header">
             <h3 class="box-title">Invoices Details</h3>
        </div>
        <br><br>
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Invoice information</a></li>
            <li><a href="#tab_2" data-toggle="tab">Payment statuses</a></li>
            <li><a href="#tab_3" data-toggle="tab">Attachments</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
              <table class="table table-striped" style="text-align:center">
                  <tbody>
                      <tr>
                          <th scope="row">Invoice Number</th>
                          <td>{{ $invoices->invoice_number }}</td>
                          <th scope="row">Invoice Date</th>
                          <td>{{ $invoices->invoice_date }}</td>
                          <th scope="row">Due Date</th>
                          <td>{{ $invoices->due_date }}</td>
                          <th scope="row">Section</th>
                          <td>{{ $invoices->section->name }}</td>
                      </tr>
                      <tr>
                          <th scope="row">Product</th>
                          <td>{{ $invoices->product->name }}</td>
                          <th scope="row">Amount Collection</th>
                          <td>{{ $invoices->amount_collection }}</td>
                          <th scope="row">Amount Commission</th>
                          <td>{{ $invoices->amount_commission }}</td>
                          <th scope="row">Discount</th>
                          <td>{{ $invoices->discount }}</td>
                      </tr>
                      <tr>
                          <th scope="row">Tax Rate</th>
                          <td>{{ $invoices->rate_vat }}</td>
                          <th scope="row">Tax Value</th>
                          <td>{{ $invoices->value_vat }}</td>
                          <th scope="row">Total with tax</th>
                          <td>{{ $invoices->total }}</td>
                          <th scope="row">Current Status</th>
                          @if ($invoices->value_status == 1)
                            <td><span class="text-success">{{ $invoices->status }}</span></td>
                          @elseif($invoices->value_status == 2)
                            <td><span class="text-danger">{{ $invoices->status }}</span></td>
                          @else
                            <td><span class="text-warning">{{ $invoices->status }}</span></td>
                          @endif
                      </tr>
                      <tr>
                          <th scope="row">Notes</th>
                          <td>{{ $invoices->note }}</td>
                          <th scope="row">Created By</th>
                          <td>{{ $invoices->created_by }}</td>
                      </tr>
                  </tbody>
              </table>
            </div>
            <div class="tab-pane" id="tab_2">
              <table class="table center-aligned-table mb-0 table-hover">
                  <thead>
                      <tr class="text-dark">
                          <th>#</th>
                          <th>Invoice Number</th>
                          <th>Section Name</th>
                          <th>Product Name</th>
                          <th>Payment Status</th>
                          <th>Payment Date</th>
                          <th>Notes</th>
                          <th>Added Date</th>
                          <th>Created By</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach ($details as $index=>$detail)
                      <tr>
                          <td>{{ $index + 1 }}</td>
                          <td>{{ $detail->invoice_number }}</td>
                          <td>{{ $invoices->section->name }}</td>
                          <td>{{ $invoices->product->name }}</td>
                          @if ($detail->value_status == 1)
                              <td><span class="text-success">{{ $detail->status }}</span></td>
                          @elseif($detail->value_status == 2)
                              <td><span class="text-danger">{{ $detail->status }}</span></td>
                          @else
                              <td><span class="text-warning">{{ $detail->status }}</span></td>
                          @endif
                          <td>{{ $detail->payment_date }}</td>
                          <td>{{ $detail->note }}</td>
                          <td>{{ $detail->created_at }}</td>
                          <td>{{ $detail->created_by }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                      <tr class="text-dark">
                          <th>#</th>
                          <th>Invoice Number</th>
                          <th>Section Name</th>
                          <th>Product Name</th>
                          <th>Payment Status</th>
                          <th>Payment Date</th>
                          <th>Notes</th>
                          <th>Added Date</th>
                          <th>Created By</th>
                      </tr>
                  </tfoot>
              </table>
            </div>
            <div class="tab-pane" id="tab_3">
              <div class="card-body">
                  <p class="text-danger">* Attachment Format : pdf , docx , xlsx , zip , txt , jpg , jpeg , png , mp3 , mp4 </p>
                      <h5 class="card-title">Add Attachments</h5>
                        <form method="post" action="{{ url('invoiceattachmentsadd') }}" enctype="multipart/form-data">
                          {{ csrf_field() }}
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="customFile" name="file_name" required>
                            <input type="hidden" id="customFile" name="invoice_number" value="{{ $invoices->invoice_number }}">
                            <input type="hidden" id="invoice_id" name="invoice_id" value="{{ $invoices->id }}">
                          </div>
                          <br>
                          <button type="submit" class="btn btn-primary">Save changes</button>
                        </form>
              </div>
              <table class="table center-aligned-table mb-0 table-hover">
                  <thead>
                      <tr class="text-dark">
                          <th>#</th>
                          <th>File Name</th>
                          <th>Invoice Number</th>
                          <th>Created By</th>
                          <th>Added Date</th>
                          <th>Operation</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach ($attachments as $index=>$attachment)
                      <tr>
                          <td>{{ $index + 1 }}</td>
                          <td>{{ $attachment->file_name }}</td>
                          <td>{{ $attachment->invoice_number }}</td>
                          <td>{{ $attachment->created_by }}</td>
                          <td>{{ $attachment->created_at }}</td>
                          <td>

                              <a class="btn btn-success btn-sm"
                              href="{{ url('View_file') }}/{{ $invoices->invoice_number }}/{{ $attachment->file_name }}"
                              role="button"><i class="fa fa-folder-open-o"></i></a>

                              <a class="btn btn-info btn-sm"
                              href="{{ url('Download') }}/{{ $invoices->invoice_number }}/{{ $attachment->file_name }}"
                              role="button"><i class="fa fa-download"></i></a>

                              <a class="btn btn-sm btn-danger"
                              data-id="{{ $attachment->id }}"
                              data-file_name="{{ $attachment->file_name }}"
                              data-invoice_number="{{ $attachment->invoice_number }}"
                              data-toggle="modal" data-target="#delete_file"><i class="fa fa-trash"></i></a>

                          </td>
                      </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                      <tr class="text-dark">
                          <th>#</th>
                          <th>File Name</th>
                          <th>Invoice Number</th>
                          <th>Created By</th>
                          <th>Added Date</th>
                          <th>Operation</th>
                      </tr>
                  </tfoot>
              </table>
            </div>
          </div>
        </div>
       </div>
      </div>
    </div>
   </section>
</div>

<!-- Delete -->
<div class="modal fade" id="delete_file">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
            <h4 class="modal-title">Delete File</h4>
      </div>
      <div class="modal-body">
        <form action="{{ route('delete_file') }}" method="post">
                  {{ csrf_field() }}
                  <div class="modal-body">
                      <p>Are sure of the deleting process ?</p><br>
                      <input type="hidden" name="id" id="id" value="">
                      <input type="hidden" name="file_name" id="file_name" value="">
                      <input type="hidden" name="invoice_number" id="invoice_number" value="">
                      <input class="form-control" name="file_name" id="file_name" type="text" readonly>

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
<script>
  $('#delete_file').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget)
      var id = button.data('id')
      var file_name = button.data('file_name')
      var invoice_number = button.data('invoice_number')
      var modal = $(this)
      modal.find('.modal-body #id').val(id);
      modal.find('.modal-body #file_name').val(file_name);
      modal.find('.modal-body #invoice_number').val(invoice_number);
  })
</script>
@endsection

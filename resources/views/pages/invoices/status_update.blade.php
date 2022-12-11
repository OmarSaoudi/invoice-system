@extends('layouts.master')

@section('title')
    Invoices | Change invoice payment status
@stop

@section('css')

@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Change invoice payment status
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ route('invoices.index') }}"><i class="fa fa-file-text-o"></i> Invoices</a></li>
        <li class="active">Change invoice payment status</li>
      </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Change invoice payment status</h3>
                </div>
                <div class="box-body">
                    <form action="{{ route('status_update', ['id' => $invoices->id]) }}" method="post" autocomplete="off">
                        {{ csrf_field() }}
                        {{-- 1 --}}
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Invoice Number</label>
                                 <input type="hidden" name="invoice_id" value="{{ $invoices->id }}">
                                 <input type="text" name="invoice_number" value="{{ $invoices->invoice_number }}" class="form-control" readonly>
                              </div>
                            </div>

                            <div class="col-md-4">
                                <label>Invoice Date</label>
                                <input type="date" class="form-control" name="invoice_date" value="{{ $invoices->invoice_date }}"  readonly>
                            </div>

                            <div class="col-md-4">
                                <label>Due Date</label>
                                <input type="date" class="form-control" name="due_date" value="{{ $invoices->due_date }}" readonly>
                            </div>

                        </div>
                        {{-- End 1 --}}

                        {{-- 2 --}}
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Section Name</label>
                                 <input type="text" class="form-control" name="section_id" value="{{ $invoices->section->name }}" readonly>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                 <label>Product Name</label>
                                 <input type="text" class="form-control" name="product_id" value="{{ $invoices->product->name }}" readonly>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                 <label>Amount Collection</label>
                                 <input type="text" class="form-control" name="amount_collection" value="{{ $invoices->amount_collection }}" readonly>
                              </div>
                            </div>
                        </div>
                        {{-- End 2 --}}

                        {{-- 3 --}}
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Amount Commission</label>
                                 <input type="text" class="form-control form-control-lg" id="amount_commission" value="{{ $invoices->amount_commission }}" name="amount_commission" readonly>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                 <label>Discount</label>
                                 <input type="text" class="form-control form-control-lg" id="discount" name="discount" value="{{ $invoices->discount }}" readonly>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                 <label>Rate Vat</label>
                                 <input type="text" class="form-control" name="rate_vat" value="{{ $invoices->rate_vat }}" onchange="myFunction()" readonly>
                              </div>
                            </div>
                        </div>
                        {{-- End 3 --}}

                        {{-- 4 --}}
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>Value Added Tax</label>
                                 <input type="text" class="form-control" id="value_vat" name="value_vat" value="{{ $invoices->value_vat }}" readonly>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                 <label>Total including tax</label>
                                 <input type="text" class="form-control" id="total" name="total" value="{{ $invoices->total }}" readonly>
                              </div>
                            </div>
                        </div>
                        {{-- End 4 --}}

                        {{-- 5 --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Notes</label>
                                    <textarea class="form-control" name="note" rows="3" readonly>{{ $invoices->note }}</textarea>
                                </div>
                            </div>
                        </div>
                        {{-- End 5 --}}

                        {{-- 6 --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                   <label>Payment Status</label>
                                   <select id="status" name="status" class="form-control" required>
                                      <option value="{{ $invoices->status }}">{{ $invoices->status }}</option>
                                      <option value="Paid">Paid</option>
                                      <option value="Partially paid">Partially paid</option>
                                   </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Payment Date</label>
                                    <input type="date" name="payment_date" value="{{ $invoices->payment_date }}" class="form-control fc-datepicker" required>
                                </div>
                            </div>
                        </div>
                        {{-- End 6 --}}

                        <br><br>
                        <div class="form-group" style="text-align:center">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Saving Data</button>
                            <a href="{{ route('invoices.index') }}" class="btn btn-warning"><i class="fa fa-undo"></i> Back</a>
                        </div>
                    </form>
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
@endsection

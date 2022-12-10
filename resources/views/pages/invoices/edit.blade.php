@extends('layouts.master')

@section('title')
    Edit Invoice
@stop

@section('css')

@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Invoices
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Invoices</li>
        <li class="active">Edit Invoice</li>
      </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Edit Invoice</h3>
                </div>
                <div class="box-body">
                    <form action="{{ url('invoices/update') }}" method="post" autocomplete="off">
                        {{ method_field('patch') }}
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
                                <input type="date" class="form-control" name="invoice_date" value="{{ $invoices->invoice_date }}"  required>
                            </div>

                            <div class="col-md-4">
                                <label>Due Date</label>
                                <input type="date" class="form-control" name="due_date" value="{{ $invoices->due_date }}" required>
                            </div>

                        </div>
                        {{-- End 1 --}}

                        {{-- 2 --}}
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Section Name</label>
                                 <select name="section_id" class="form-control" onclick="console.log($(this).val())"
                                    onchange="console.log('change is firing')">
                                    <option value="{{ $invoices->section->id }}">{{ $invoices->section->name }}</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}"> {{ $section->name }}</option>
                                    @endforeach
                                 </select>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                 <label>Product Name</label>
                                 <select id="product_id" name="product_id" class="form-control">
                                     <option value="{{ $invoices->product_id }}"> {{ $invoices->product->name }}</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                 <label>Amount Collection</label>
                                 <input type="text" class="form-control" name="amount_collection" value="{{ $invoices->amount_collection }}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                              </div>
                            </div>
                        </div>
                        {{-- End 2 --}}

                        {{-- 3 --}}
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label>Amount Commission</label>
                                 <input type="text" class="form-control form-control-lg" id="amount_commission" value="{{ $invoices->amount_commission }}"
                                    name="amount_commission" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                 <label>Discount</label>
                                 <input type="text" class="form-control form-control-lg" id="discount" name="discount" value="{{ $invoices->discount }}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value=0 required>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                 <label>Rate Vat</label>
                                 <select name="rate_vat" id="rate_vat" class="form-control" onchange="myFunction()">
                                    <option value="{{ $invoices->rate_vat }}">{{ $invoices->rate_vat }}</option>
                                    <option value="5%">5%</option>
                                    <option value="7%">7%</option>
                                    <option value="10%">10%</option>
                                    <option value="19%">19%</option>
                                 </select>
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
                                <label>Notes</label>
                                <textarea class="form-control" name="note" rows="3">{{ $invoices->note }}</textarea>
                            </div>
                        </div>
                        {{-- End 5 --}}

                        <br><br>
                        <div class="form-group" style="text-align:center">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Saving Data</button>
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

<script>
    $(document).ready(function () {
        $('select[name="section_id"]').on('change', function () {
            var section_id = $(this).val();
            if (section_id) {
                $.ajax({
                    url: "{{ URL::to('section') }}/" + section_id,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('select[name="product_id"]').empty();
                        $.each(data, function (key, value) {
                            $('select[name="product_id"]').append('<option value="' + key + '">' + value + '</option>');
                        });
                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });
</script>

<script>
    function myFunction() {
        var amount_commission = parseFloat(document.getElementById("amount_commission").value);
        var discount = parseFloat(document.getElementById("discount").value);
        var rate_vat = parseFloat(document.getElementById("rate_vat").value);
        var value_vat = parseFloat(document.getElementById("value_vat").value);
        var amount_commission2 = amount_commission - discount;
        if (typeof amount_commission === 'undefined' || !amount_commission) {
            alert('يرجي ادخال مبلغ العمولة ');
        } else {
            var intResults = amount_commission2 * rate_vat / 100;
            var intResults2 = parseFloat(intResults + amount_commission2);
            sumq = parseFloat(intResults).toFixed(2);
            sumt = parseFloat(intResults2).toFixed(2);
            document.getElementById("value_vat").value = sumq;
            document.getElementById("total").value = sumt;
        }
    }
</script>
@endsection

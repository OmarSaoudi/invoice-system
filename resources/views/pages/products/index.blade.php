@extends('layouts.master')

@section('title')
    Products
@stop

@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Products
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Products</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Products List</h3>
            <br><br>
            <a class="btn btn-success" data-toggle="modal" data-target="#AddProduct"><i class="fa fa-plus"></i> Add</a>
            <button type="button" class="btn btn-danger" id="btn_delete_all"><i class="fa fa-trash"></i> Delete All</button>
            <br><br>
            <div class="col-md-2">
               <form action="{{ route('Filter_Products_Section') }}" method="POST">
                @csrf
                  <select class="form-control" data-style="btn btn-info" name="section_id" required onchange="this.form.submit()">
                    <option value="" selected disabled>Search By Section</option>
                      @foreach ($sections as $section)
                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                      @endforeach
                  </select>
               </form>
            </div>
            <br><br>
          <!-- /.box-header -->
          <div class="box-body" id="datatable">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th><input type="checkbox" name="select_all" id="example-select-all" onclick="CheckAll('box1', this)"></th>
                <th>#</th>
                <th>Name</th>
                <th>Section Name</th>
                <th>Operation</th>
              </tr>
              </thead>
              <tbody>
              @if (isset($details))
                 <?php $products = $details; ?>
              @else
                 <?php $products = $products; ?>
              @endif
              @foreach($products as $product)
              <tr>
                <td><input type="checkbox"  value="{{ $product->id }}" class="box1"></td>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->section->name }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit{{ $product->id }}"><i class="fa fa-edit"></i></a>
                    <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{ $product->id }}"><i class="fa fa-trash"></i></a>
                </td>
              </tr>

              <!-- Edit -->
               <div class="modal fade" id="edit{{ $product->id }}">
                 <div class="modal-dialog">
                   <div class="modal-content">
                     <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                       <h4 class="modal-title">Product Update</h4>
                     </div>
                    <div class="modal-body">
                     <form action="{{ route('products.update', 'test') }}" method="POST">
                      {{ method_field('PATCH') }}
                      @csrf
                        <div class="form-group">
                          <input type="hidden" name="id" id="id" value="{{ $product->id }}">
                          <label>Product Name Arabic</label>
                          <input type="text" name="name" id="name" value="{{ $product->getTranslation('name', 'ar') }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                          <label>Product Name English</label>
                          <input type="text" name="name_en" id="name_en" value="{{ $product->getTranslation('name', 'en') }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Section Name</label>
                            <select name="section_id" class="form-control" required>
                            <option value="{{ $product->section->id }}">{{ $product->section->name }}</option>
                              @foreach ($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                              @endforeach
                          </select>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary">Save changes</button>
                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        </div>
                     </form>
                    </div>
                   </div>
                 </div>
               </div>
              <!-- Edit End -->

              <!-- Delete -->
                <div class="modal fade" id="delete{{ $product->id }}">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title">Delete Product</h4>
                        </div>
                       <div class="modal-body">
                        <form action="{{ route('products.destroy', 'test') }}" method="POST">
                            {{ method_field('Delete') }}
                            @csrf
                            <div class="modal-body">
                                <p>Are sure of the deleting process ?</p><br>
                                <input id="id" type="hidden" name="id" class="form-control" value="{{ $product->id }}">
                                <input class="form-control" name="name" value="{{ $product->name }}" type="text" readonly>
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
              <!-- Delete End -->

              @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th><input type="checkbox" name="select_all" id="example-select-all" onclick="CheckAll('box1', this)"></th>
                  <th>#</th>
                  <th>Name</th>
                  <th>Section Name</th>
                  <th>Operation</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>

<!-- Add -->
  <div class="modal fade" id="AddProduct">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
              <h4 class="modal-title">Add Product</h4>
        </div>
        <div class="modal-body">
          <form action="{{ route('products.store') }}" method="post">
              @csrf
                <div class="form-group">
                  <label>Product Name Arabic</label>
                  <input type="text" name="name" id="name" class="form-control">
                </div>
                <div class="form-group">
                  <label>Product Name English</label>
                  <input type="text" name="name_en" id="name_en" class="form-control">
                </div>
                <div class="form-group">
                  <label>Section Name</label>
                  <select name="section_id" id="section_id" class="form-control" required>
                    <option value="" selected disabled> -- Select Section --</option>
                    @foreach ($sections as $section)
                      <option value="{{ $section->id }}">{{ $section->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-success">Save changes</button>
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<!-- End Add -->

<!-- Delete All -->
  <div class="modal fade" id="delete_all_p">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
              <h4 class="modal-title">Delete All Products</h4>
        </div>
        <div class="modal-body">
          <form action="{{ route('delete_all_p') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>Are sure of the deleting process ?</p><br>
                        <input class="text" type="hidden" id="delete_all_id" name="delete_all_id" value=''>
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
<!-- End Delete All -->

@endsection




@section('scripts')
<script src="{{ URL::asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
  $(function () {
    $('#example1').DataTable()
  })
</script>
<script type="text/javascript">
    $(function() {
       $("#btn_delete_all").click(function() {
           var selected = new Array();
           $("#datatable input[type=checkbox]:checked").each(function() {
               selected.push(this.value);
           });
           if (selected.length > 0) {
               $('#delete_all_p').modal('show')
               $('input[id="delete_all_id"]').val(selected);
           }
       });
    });
</script>
@endsection

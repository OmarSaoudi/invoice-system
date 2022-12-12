<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->name }}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
      <li class="header">MASTER</li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-cog"></i>
          <span>Invoices</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('invoices.index') }}"><i class="fa fa-file-text-o"></i> <span>Invoices</span></a></li>
          <li><a href="{{ url('/' . ($page = 'invoice_paid')) }}"><i class="fa fa-file-text-o"></i> <span>Invoices Paid</span></a></li>
          <li><a href="{{ url('/' . ($page = 'invoice_unpaid')) }}"><i class="fa fa-file-text-o"></i> <span>Invoices Unpaid</span></a></li>
          <li><a href="{{ url('/' . ($page = 'invoice_partially')) }}"><i class="fa fa-file-text-o"></i> <span>Invoices Partially</span></a></li>
          <li><a href="{{ route('archives.index') }}"><i class="fa fa-exchange"></i> Archived Invoices</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-bar-chart"></i>
          <span>Reports</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ url('/' . ($page = 'invoices_report')) }}"><i class="fa fa-line-chart"></i> <span>Invoices Reports</span></a></li>
        </ul>
      </li>
      <li><a href="{{ route('sections.index') }}"><i class="fa fa-usd"></i> <span>Sections</span></a></li>
      <li><a href="{{ route('products.index') }}"><i class="fa fa-product-hunt"></i> <span>Products</span></a></li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>

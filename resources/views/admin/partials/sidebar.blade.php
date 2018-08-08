<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{url('/dist/img/avatar5.png')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Admin</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <!-- <li class="header">MAIN NAVIGATION</li> -->
        <li class="active treeview">
          <a href="{{url('/adminboard')}}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            {{-- <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span> --}}
          </a>
        </li>
        <!-- <li class="active treeview">
          <a href="{{url('/admin/post/list')}}">
            <i class="fa fa-file-text"></i> <span>Posts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="{{url('/admin/post/list')}}">
                <i class="fa fa-table"></i>
                <span>List Posts</span>
              </a>
            </li>
            <li>
              <a href="{{url('/admin/post/add')}}">
                <i class="fa fa-edit"></i> <span>Add Posts</span>
              </a>
            </li>
            <li>
              <a href="{{url('/admin/post/category')}}">
                <i class="fa fa-edit"></i> <span>Category</span>
              </a>
            </li>
          </ul>
        </li> -->
        <li class="active treeview">
          <a href="{{url('/admin/page/list')}}">
            <i class="fa fa-file-text"></i> <span>Pages</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="{{url('/admin/page/list')}}">
                <i class="fa fa-table"></i>
                <span>List Pages</span>
              </a>
            </li>
            <li>
              <a href="{{url('/admin/page/add')}}">
                <i class="fa fa-edit"></i> <span>Add Pages</span>
              </a>
            </li>
          </ul>
        </li>
        <!--<li class="active treeview">
          <a href="{{url('/admin/ads/list')}}">
            <i class="fa fa-file-text"></i> <span>Advertise</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="{{url('/admin/ads/list')}}">
                <i class="fa fa-table"></i>
                <span>List Ads</span>
              </a>
            </li>
            <li>
              <a href="{{url('/admin/ads/add')}}">
                <i class="fa fa-edit"></i> <span>Add Ads</span>
              </a>
            </li>
            <li>
              <a href="{{url('/admin/ads/position')}}">
                <i class="fa fa-edit"></i> <span>Ads Position</span>
              </a>
            </li>
          </ul>
        </li>-->

        <!--<li class="active treeview">
          <a href="{{url('/admin/ads/list')}}">
            <i class="fa fa-file-text"></i> <span>Price Search</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="{{url('/admin/price/product-list')}}">
                <i class="fa fa-table"></i>
                <span>List Products</span>
              </a>
            </li>

            <li>
              <a href="{{url('/admin/price/product/add')}}">
                <i class="fa fa-edit"></i>
                <span>Add Product</span>
              </a>
            </li>

            <li>
              <a href="{{url('/admin/price/category')}}">
                <i class="fa fa-edit"></i>
                <span>Product Categories</span>
              </a>
            </li>

            <li>
              <a href="{{url('/admin/price/brand')}}">
                <i class="fa fa-edit"></i>
                <span>List Brands</span>
              </a>
            </li>
          </ul>
        </li>-->

        <li class="active treeview">
          <a href="{{url('/admin/product/list')}}">
            <i class="fa fa-file-text"></i> <span>Products</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="{{url('/admin/product/list')}}">
                <i class="fa fa-table"></i>
                <span>List Products</span>
              </a>
            </li>
            <li>
              <a href="{{url('/admin/product/add')}}">
                <i class="fa fa-edit"></i> <span>Add Products</span>
              </a>
            </li>
            <li>
              <a href="{{url('/admin/product/category/add')}}">
                <i class="fa fa-puzzle-piece"></i> <span>Category</span>
              </a>
            </li>

            <li>
              <a href="{{url('/admin/product/brand')}}">
                <i class="fa fa-puzzle-piece"></i> <span>Brand</span>
              </a>
            </li>
            <!-- <li>
              <a href="/admin/home/slider/add">
                <i class="fa fa-image"></i> <span>Home Sliders</span>
              </a>
            </li> -->
          </ul>
        </li>


      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item {{ Request::is('/admin/dashboard') ? 'active': '' }}">
            <a class="nav-link" href="/admin/dashboard">
              <i class="mdi mdi-home menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
         {{-- Orders --}}
          <li class="nav-item {{ Request::is('/admin/orders') ? 'active': '' }}">
            <a class="nav-link" href="{{ url('admin/orders') }}">
              <i class="mdi mdi-sale menu-icon"></i>
              <span class="menu-title">Đơn Hàng</span>
            </a>
          </li>
          <!-- Category Dropdown -->
          <li class="nav-item {{ Request::is('/admin/category*') ? 'active': '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#category" 
              aria-expanded="{{ Request::is('/admin/category*') ? 'true': 'false' }}">

                <i class="mdi mdi-server menu-icon"></i>
                <span class="menu-title">Danh Mục</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ Request::is('/admin/category*') ? 'show': '' }}" id="category">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/admin/category/create') ? 'active': '' }}" href="{{ url('admin/category/create') }}">Thêm Danh Mục</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/admin/category') || Request::is('/admin/category/*/edit') ? 'active': '' }}" href="{{ url('admin/category') }}">Xem Danh Mục</a>
                    </li>
                </ul>
            </div>
          </li>

          <!-- Product Dropdown -->
          <li class="nav-item {{ Request::is('/admin/products*') ? 'active': '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#product" 
              aria-expanded="{{ Request::is('/admin/products*') ? 'true': 'false' }}">

                <i class="mdi mdi-plus-circle menu-icon"></i>
                <span class="menu-title">Sản Phẩm</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ Request::is('/admin/products*') ? 'show': '' }}" id="product">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/admin/products/create') ? 'active': '' }}" href="{{ url('admin/products/create') }}">Thêm Sản Phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/admin/products') || Request::is('/admin/products/*/edit') ? 'active': '' }}" href="{{ url('admin/products') }}">Xem Sản Phẩm</a>
                    </li>
                </ul>
            </div>
          </li>

          <li class="nav-item {{ Request::is('/admin/brands') ? 'active': '' }}">
            <a class="nav-link" href="{{ url('/admin/brands') }}">
              <i class="mdi mdi-view-headline menu-icon"></i>
              <span class="menu-title">Thương Hiệu</span>
            </a>
          </li>
          <li class="nav-item {{ Request::is('/admin/colors') ? 'active': '' }}">
            <a class="nav-link" href="{{ url('/admin/colors') }}">
              <i class="mdi mdi-view-headline menu-icon"></i>
              <span class="menu-title">Màu</span>
            </a>
          </li>
          
          
          <li class="nav-item {{ Request::is('/admin/users*') ? 'active': '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#auth" 
              aria-expanded="{{ Request::is('/admin/users*') ? 'true': 'false' }}">

              <i class="mdi mdi-account menu-icon"></i>
              <span class="menu-title">Người Dùng</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ Request::is('/admin/users*') ? 'show': '' }}" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> 
                  <a class="nav-link {{ Request::is('/admin/users/create') ? 'active': '' }}" href="{{ url('admin/users/create') }}"> Thêm Người Dùng </a>
                </li>
                <li class="nav-item"> 
                  <a class="nav-link {{ Request::is('/admin/users') || Request::is('/admin/users/*/edit') ? 'active': '' }}" href="{{ url('admin/users') }}"> Xem Người Dùng </a>
                </li>
              </ul>
            </div>
          </li>
          
          <li class="nav-item {{ Request::is('/admin/sliders') ? 'active': '' }}">
            <a class="nav-link" href="{{ url('/admin/sliders') }}">
              <i class="mdi mdi-view-carousel menu-icon"></i>
              <span class="menu-title">Home Slider</span>
            </a>
          </li>
          <li class="nav-item {{ Request::is('/admin/settings') ? 'active': '' }}">
            <a class="nav-link" href="{{ url('/admin/settings') }}">
              <i class="mdi mdi-settings menu-icon"></i>
              <span class="menu-title">Site Setting</span>
            </a>
          </li>
          
        </ul>
      </nav>
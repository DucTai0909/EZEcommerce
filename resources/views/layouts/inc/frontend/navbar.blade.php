<div class="main-navbar shadow-sm sticky-top">
    <div class="top-navbar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2 my-auto d-none d-sm-none d-md-block d-lg-block">
                   <a class="brand-name-link" href="{{ url('/') }}"><h5 class="brand-name">{{ $appSetting->website_name ?? 'website name' }}</h5></a>
                </div>
                <div class="col-md-5 my-auto">
                    <form action="{{ url('search') }}" method="GET" role="search">
                        <div class="input-group">
                            <input type="search" name="search" value="{{ Request::get('search') }}" placeholder="Tìm kiếm sản phẩm" class="form-control" />
                            <button class="btn bg-white" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-5 my-auto">
                    <ul class="nav justify-content-end">
                        
                        <!-- Add the 'active' class to the appropriate nav item -->
                        <li class="nav-item {{ request()->is('cart*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('cart') }}">
                                <i class="fa fa-shopping-cart"></i> Giỏ Hàng ( <livewire:frontend.cart.cart-count/> )
                            </a>
                        </li>

                        <li class="nav-item {{ request()->is('wishlist') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('wishlist') }}">
                                <i class="fa fa-heart"></i> Yêu Thích ( <livewire:frontend.wishlist-count/> )
                            </a>
                        </li>

                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Đăng nhập') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Đăng ký') }}</a>
                                </li>
                            @endif
                        @else
                            
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"  aria-expanded="false">
                                <i class="fa fa-user"></i>  {{ Auth::user()->name }}
 
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ url('profile') }}"><i class="fa fa-user"></i> Tài Khoản</a></li>
                            <li><a class="dropdown-item" href="{{ url('orders') }}"><i class="fa fa-list"></i> Đơn Hàng</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fa fa-heart"></i> Yêu Thích</a></li>
                            <li><a class="dropdown-item" href="{{ url('cart') }}"><i class="fa fa-shopping-cart"></i> Giỏ Hàng</a></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out"></i>Đăng Xuất
                                 </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                            </li>
                            </ul>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand d-block d-sm-block d-md-none d-lg-none" href="{{ url('/') }}">
                DT Ecom
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Trang Chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/collections') }}">Danh Mục Sản Phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('new-arrivals') }}">Sản Phẩm Mới</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('featured-products') }}">Sản Phẩm Hot</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#">Electronics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Fashions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Accessories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Appliances</a>
                    </li> --}}
                </ul>
            </div>
        </div>
    </nav>
</div>

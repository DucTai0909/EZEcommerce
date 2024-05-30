@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin">
    @if(session('message'))
      <h2 class="alert alert-success">{{session('message')}},</h2>
    @endif
    <div class="me-md-3 me-xl-5">
      <h2>Dashboard</h2>
      <p class="mb-md-0"></p>
      <hr>
    </div>
    <div class="row">
      <div class="col-md-3">
        <div class="card card-body bg-primary text-white mb-3">
          <label>Tổng Đơn Hàng</label>
          <h1>{{ $totalOrder }}</h1>
          <a href="{{ url('admin/orders') }}" class="text-white">Xem</a>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="card card-body bg-success text-white mb-3">
          <label>Đơn Hàng Hôm Nay</label>
          <h1>{{ $todayOrder }}</h1>
          <a href="{{ url('admin/orders') }}" class="text-white">Xem</a>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card card-body bg-warning text-white mb-3">
          <label>Đơn Hàng Tháng Này</label>
          <h1>{{ $thisMonthOrder }}</h1>
          <a href="{{ url('admin/orders') }}" class="text-white">Xem</a>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card card-body bg-danger text-white mb-3">
          <label>Đơn Hàng Năm Nay</label>
          <h1>{{ $thisYearOrder }}</h1>
          <a href="{{ url('admin/orders') }}" class="text-white">Xem</a>
        </div>
      </div>

    </div>

    <hr>
    <div class="row">
      <div class="col-md-3">
        <div class="card card-body bg-primary text-white mb-3">
          <label>Tổng Sản Phẩm</label>
          <h1>{{ $totalProducts }}</h1>
          <a href="{{ url('admin/products') }}" class="text-white">Xem</a>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="card card-body bg-success text-white mb-3">
          <label>Tổng Danh Mục Sản Phẩm</label>
          <h1>{{ $totalCategories }}</h1>
          <a href="{{ url('admin/category') }}" class="text-white">Xem</a>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card card-body bg-warning text-white mb-3">
          <label>Tổng Số Thương Hiệu</label>
          <h1>{{ $totalBrands }}</h1>
          <a href="{{ url('admin/brands') }}" class="text-white">Xem</a>
        </div>
      </div>

    </div>

    <hr>
    <div class="row">
      <div class="col-md-3">
        <div class="card card-body bg-primary text-white mb-3">
          <label>Số Lượng Người Dùng</label>
          <h1>{{ $totalAllUsers }}</h1>
          <a href="{{ url('admin/users') }}" class="text-white">Xem</a>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="card card-body bg-success text-white mb-3">
          <label>Số Lượng Khách Hàng</label>
          <h1>{{ $totalUser }}</h1>
          <a href="{{ url('admin/users') }}" class="text-white">Xem</a>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card card-body bg-warning text-white mb-3">
          <label>Số Lượng Admin</label>
          <h1>{{ $totalAdmin }}</h1>
          <a href="{{ url('admin/users') }}" class="text-white">Xem</a>
        </div>
      </div>

    </div>
  </div>
</div>



@endsection
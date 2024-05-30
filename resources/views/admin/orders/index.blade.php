@extends('layouts.admin')
@section('title', 'Orders')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>Đơn Hàng</h3>
            </div>
            <div class="card-body">

                <form action="" method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Lọc Theo Ngày</label>
                            <input type="date" name="date" value="{{ Request::get('date')  }}" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label>Lọc Theo Trạng Thái</label>
                            <select name="status" class="form-select">
                                <option value="">Select All Status</option>
                                <option value="in progress" {{ Request::get('status') =='in progress' ? 'selected' :'' }}>In Progress</option>
                                <option value="completed" {{ Request::get('status') =='completed' ? 'selected' :'' }}>Completed</option>
                                <option value="pending" {{ Request::get('status') =='pending' ? 'selected' :'' }}>Pending</option>
                                <option value="cancelled" {{ Request::get('status') =='cancelled' ? 'selected' :'' }}>Cancelled</option>
                                <option value="out-for-delivery" {{ Request::get('status') =='out-for-delivery' ? 'selected' :'' }}>Out For Delivery</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <br/>
                            <button class="btn btn-primary" type="submit">Lọc</button>
                        </div>
                    </div>
                </form>
                <hr>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <th>ID Đơn Hàng</th>
                                    <th>Tracking Num</th>
                                    <th>Username</th>
                                    <th>Phương Thức Thanh Toán</th>
                                    <th>Ngày Đặt Hàng</th>
                                    <th>Trạng Thái</th>
                                    <th>Hành Động</th>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->tracking_no }}</td>
                                            <td>{{ $item->fullname }}</td>
                                            <td>{{ $item->payment_mode }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->status_message }}</td>
                                            <td><a href="{{ url('admin/orders/'.$item->id) }}" class="btn btn-primary btn-sm">View</a></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">Không Có Đơn Hàng</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div>
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
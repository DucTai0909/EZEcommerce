@extends('layouts.admin')
@section('title', 'Product')

@section('content')


<div class="row">
    <div class="col-md-12">

        @if (session('message'))
            <div id="responseMessage" class="alert alert-success">{{ session('message') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3>Sản Phẩm
                    <a href="{{ url('admin/products/create') }}" 
                        class="btn btn-primary btn-sm text-white float-end">Thêm Sản Phẩm
                    </a>
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Danh Mục</th>
                            <th>Sản Phẩm</th>
                            <th>Giá</th>
                            <th>Số Lượng</th>
                            <th>Tình Trạng</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>
                                @if ($product->category)
                                    {{$product->category->name}}
                                @else
                                    No Category
                                @endif
                            </td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->selling_price}}</td>
                            <td>{{$product->quantity}}</td>
                            <td>{{$product->status == '1' ? 'Hidden' : 'Visible'}}</td>
                            <td>
                                <a href="{{ url('admin/products/'.$product->id.'/edit') }}" class="btn btn-sm btn-success">Edit</a>
                                <a href="{{ url('admin/products/'.$product->id.'/delete') }}" onclick="return confirm('Make sure that you want to delete this data?')" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">No Product Avaliable</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Check if the success message exists
        if ($('#responseMessage').length > 0) {
            // Hide the success message after 4000 milliseconds (4 seconds)
            setTimeout(function () {
                $('#responseMessage').fadeOut('slow');
            }, 2500);
        }
    });
</script>
@endsection
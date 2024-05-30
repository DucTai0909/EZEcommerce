@extends('layouts.admin')
@section('title', 'Users')

@section('content')


<div class="row">
    <div class="col-md-12">

        @if (session('message'))
            <div id="responseMessage" class="alert alert-success">{{ session('message') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3>Thêm Người Dùng
                    <a href="{{ url('admin/users') }}" 
                        class="btn btn-danger btn-sm text-white float-end">Trở Lại
                    </a>
                </h3>
            </div>
            <div class="card-body">
                
                @if ($errors->any())
                    <ul class="alert alert-warning">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <form action="{{ url('admin/users') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tên</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Mật Khẩu</label>
                            <input type="text" name="password" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Chọn Vai Trò</label>
                            <select name="role_as" class="form-control">
                                <option value="">Chọn Vai Trò</option>
                                <option value="0">Khách</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
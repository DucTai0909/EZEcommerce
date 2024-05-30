@extends('layouts.app')
@section('title', 'Tài khoản')

@section('content')

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h4><b>Tài Khoản
                    <a href="{{ url('change-password') }}" class="btn btn-warning float-end">Đổi Mật Khẩu</a></b></h4>
                <div class="underline mb-4"></div>
            </div>

            <div class="col-md-10">
                @if (session('message'))
                    <p id="responseMessage" class="alert alert-success">{{ session('message') }}</p>
                @endif
                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="card shadow">
                    <div class="card-header bg-primary">
                        <h4 class="mb-0 text-white"><b>Thông Tin Tài Khoản</b></h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('profile') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Username</label>
                                        <input type="text" value="{{ Auth::user()->email }}" name="username" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input type="text" readonly value="{{ Auth::user()->email }}" name="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Số điện thoại</label>
                                        <input type="text" name="phone" value="{{ Auth::user()->userDetail->phone ?? '' }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Zip Code</label>
                                        <input type="text" name="pin_code" {{ Auth::user()->userDetail->pin_code ?? '' }} class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label>Địa chỉ</label>
                                        <textarea type="text" name="address" class="form-control" rows="3">{{ Auth::user()->userDetail->address ?? '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Lưu Lại</button>
                                </div>
                            </div>
                        </form>
                    </div>
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
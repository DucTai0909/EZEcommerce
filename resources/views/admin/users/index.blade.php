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
                <h3>Người Dùng
                    <a href="{{ url('admin/users/create') }}" 
                        class="btn btn-primary btn-sm text-white float-end">Thêm Người Dùng
                    </a>
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Vai trò</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->role_as == '0')
                                    <label class="badge btn-primary">Khách</label>
                                @elseif ($user->role_as == '1')
                                    <label class="badge btn-success">Admin</label>
                                @else
                                    <label class="badge btn-danger">Không Có</label>
                                @endif
                            
                            </td>

                            <td>
                                <a href="{{ url('admin/users/'.$user->id.'/edit') }}" class="btn btn-sm btn-success">Sửa</a>
                                <a href="{{ url('admin/users/'.$user->id.'/delete') }}" 
                                    onclick="return confirm('Xác Nhận Xóa Người Dùng Này')" 
                                    class="btn btn-sm btn-danger">Xóa</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">Không Tồn Tại Người Dùng</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $users->links() }}
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
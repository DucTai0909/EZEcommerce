@extends('layouts.admin')
@section('title', 'Color')

@section('content')


<div class="row">
    <div class="col-md-12">

        @if (session('message'))
            <div id="responseMessage" class="alert alert-success">{{ session('message') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3>Colors List
                    <a href="{{ url('admin/colors/create') }}" 
                        class="btn btn-primary btn-sm text-white float-end">Add Color
                    </a>
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Color Name</th>
                            <th>Color Code</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($colors as $color)
                            <tr>
                                <td>{{$color->id}}</td>
                                <td>{{$color->name}}</td>
                                <td>{{$color->code}}</td>
                                <td>{{$color->status =='1' ? 'Hidden' : 'Visible'}}</td>
                                <td>
                                    <a href="{{ url('admin/colors/'.$color->id.'/edit') }}" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="{{url('admin/colors/'.$color->id.'/delete') }}" onclick="return confirm('Make sure you want to delete this data?')" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No Color</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
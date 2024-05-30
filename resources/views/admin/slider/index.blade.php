@extends('layouts.admin')
@section('title', 'Slider')

@section('content')


<div class="row">
    <div class="col-md-12">

        @if (session('message'))
            <div id="responseMessage" class="alert alert-success">{{ session('message') }}</div>
        @endif
        @if (session('errorMessage'))
            <div id="responseMessage" class="alert alert-danger">{{ session('errorMessage') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3>Slider List
                    <a href="{{ url('admin/sliders/create') }}" 
                        class="btn btn-primary btn-sm text-white float-end">Add Slider
                    </a>
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($sliders as $slider)
                           <tr>
                                <td>{{ $slider->id }}</td>
                                <td>{{ $slider->title}}</td>
                                <td>{{ $slider->description }}</td>
                                <td>
                                    <img src="{{ asset($slider->image) }}" style="width:70px;height:70px" alt="Slider">
                                </td>
                                <td>{{ $slider->status =='1' ? 'Hidden':'Visible' }}</td>
                                <td>
                                    <a href="{{ url('admin/sliders/'.$slider->id.'/edit') }}" class="btn btn-success btn-sm">Edit</a>
                                    <a href="{{ url('admin/sliders/'.$slider->id.'/delete') }}" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Make sure you want to delete this slider?');">
                                        Delete</a>
                                </td>

                           </tr>
                       @endforeach
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
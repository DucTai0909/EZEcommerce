@extends('layouts.admin')
@section('title', 'Slider Create')

@section('content')


<div class="row">
    <div class="col-md-12">


        <div class="card">
            <div class="card-header">
                <h3>Add Slider
                    <a href="{{ url('admin/sliders') }}" 
                        class="btn btn-danger btn-sm text-white float-end">Back
                    </a>
                </h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ url('admin/sliders/create') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Status</label><br/>
                        <input type="checkbox" name="status" style="width:20px; height:20px">
                        Checked=Hidden, UnChecked=Visible
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

@endsection
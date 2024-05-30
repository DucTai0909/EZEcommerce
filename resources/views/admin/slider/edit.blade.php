@extends('layouts.admin')
@section('title', 'Slider Edit')

@section('content')


<div class="row">
    <div class="col-md-12">


        <div class="card">
            <div class="card-header">
                <h3>Edit Slider
                    <a href="{{ url('admin/sliders') }}" 
                        class="btn btn-danger btn-sm text-white float-end">Back
                    </a>
                </h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ url('admin/sliders/'.$slider->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="title" value="{{ $slider->title }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ $slider->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Image</label>
                        <input type="file" name="image" id="imageInput" class="form-control" >
                        <img id="imagePreview" src="{{ asset($slider->image) }}" style="width:200px; height:200px">
                    </div>
                    <div class="mb-3">
                        <label>Status</label><br/>
                        <input type="checkbox" name="status" {{ $slider->status =='1' ? 'checked':'' }} style="width:20px; height:20px">
                        Checked=Hidden, UnChecked=Visible
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function () {
        // Function to read and display the selected image
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imagePreview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Trigger the function when a new image is selected
        $("#imageInput").change(function () {
            readURL(this);
        });
    });
</script>
<!-- ... -->

@endsection
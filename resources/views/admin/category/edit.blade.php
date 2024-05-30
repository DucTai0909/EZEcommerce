@extends('layouts.admin')
@section('title', 'Category Edit')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>Edit Category
                    <a href="{{ url('admin/category/') }}" class="btn btn-primary btn-sm text-white float-end">Back</a>
                </h3>
            </div>
            <div class="card-body">
                
                <form method="POST" action="{{ url('admin/category/'.$category->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" 
                                value="{{$category->name}}"/>

                            @error('name')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label>Slug</label>
                            <input type="text" name="slug" class="form-control"
                                value="{{$category->slug}}"/>
                            @error('slug')<small class="text-danger">{{$message}}</small>@enderror

                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control" row="3"
                                >{{$category->description}}</textarea>
                            @error('description')<small class="text-danger">{{$message}}</small>@enderror

                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Image</label>
                            <input type="file" name="image" id="imageInput" class="form-control"/>
                            <img src="{{ asset($category->image) }}"
                                id="imagePreview" style="width:200px; height:200px"/>
                            @error('image')<small class="text-danger">{{$message}}</small>@enderror

                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Status</label><br/>
                            <input type="checkbox" name="status"
                                {{$category->status =='1' ?'checked':''}}/>

                        </div>

                        <div class="col-md-12">
                            <h4>SEO Tags</h4>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Meta title</label>
                            <input type="text" name="meta_title" class="form-control"
                                value="{{$category->meta_title}}"/>
                            @error('meta_title')<small class="text-danger">{{$message}}</small>@enderror

                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Meta keyword</label>
                            <input type="text" name="meta_keyword" class="form-control"
                                value="{{$category->meta_keyword}}"/>
                            @error('meta_keyword')<small class="text-danger">{{$message}}</small>@enderror

                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Meta description</label>
                            <textarea name="meta_description" class="form-control" row="3"
                                >{{$category->meta_description}}</textarea>
                            @error('meta_description')<small class="text-danger">{{$message}}</small>@enderror

                        </div>

                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-primary float-end">Update</button>
                            
                        </div>

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
@endsection
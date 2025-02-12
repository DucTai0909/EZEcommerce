@extends('layouts.admin')
@section('title', 'Product Edit')

@section('content')


<div class="row">
    <div class="col-md-12">
        @if (session('message'))
            <h5 id="imageDeleteSuccess" class="alert alert-success mb-2">{{session('message')}}</h5>
        @endif
        <div class="card">
            <div class="card-header">
                <h3>Edit Product
                    <a href="{{ url('admin/products') }}" 
                        class="btn btn-danger btn-sm text-white float-end">BACK
                    </a>
                </h3>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class ="alert alert-warning">
                        @foreach ($errors->all() as $error)
                            <div>{{$error}}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ url('admin/products/'.$product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" 
                                data-bs-toggle="tab" data-bs-target="#home-tab-pane" 
                                type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true"
                                >Home
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="seotag-tab" data-bs-toggle="tab" data-bs-target="#seotag-tab-pane" type="button" role="tab" aria-controls="seotag-tab-pane" aria-selected="false">
                                SEO Tag
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details-tab-pane" type="button" role="tab" aria-controls="details-tab-pane" aria-selected="false">
                                Details
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="image-tab" data-bs-toggle="tab" data-bs-target="#image-tab-pane" type="button" role="tab" aria-controls="image-tab-pane" aria-selected="false">
                                Product Image
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="colors-tab" data-bs-toggle="tab" data-bs-target="#colors-tab-pane" type="button" role="tab" aria-controls="colors-tab-pane" aria-selected="false">
                                Product Colors
                            </button>
                        </li>
                        
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade border p-3 show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                            <div class="mb-3">
                                <label>Category</label>
                                <select name="category_id" class="form-control">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' :'' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Product Name</label>
                                <input type="text" name="name" value="{{ $product->name }}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Product Slug</label>
                                <input type="text" name="slug" value="{{ $product->slug }}" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>Select Brand</label>
                                <select name="brand" class="form-control">
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->name }}" {{ $brand->name == $product->brand ? 'selected' :'' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Small Description (500 words)</label>
                                <textarea type="text" name="small_description" class="form-control" rows="4">{{ $product->small_description }}
                                </textarea>
                            </div>

                            <div class="mb-3">
                                <label>Description</label>
                                <textarea type="text" name="description" class="form-control" rows="4">{{ $product->description }}
                                </textarea>
                            </div>

                        </div>
                        
                        <div class="tab-pane fade border p-3" id="seotag-tab-pane" role="tabpanel" aria-labelledby="seotag-tab" tabindex="0">
                            <div class="mb-3">
                                <label>Meta Title</label>
                                <input type="text" name="meta_title" value="{{ $product->meta_title }}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Meta Description (500 words)</label>
                                <textarea type="text" name="meta_description"  class="form-control" rows="4">{{ $product->meta_description }}
                                </textarea>
                            </div>
                            <div class="mb-3">
                                <label>Meta Keyword (500 words)</label>
                                <textarea type="text" name="meta_keyword"  class="form-control" rows="4">s{{ $product->meta_keyword }}
                                </textarea>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade border p-3" id="details-tab-pane" role="tabpanel" aria-labelledby="details-tab" tabindex="0">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Original Price</label>
                                        <input type="text" name="original_price" value="{{ $product->original_price }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Selling Price</label>
                                        <input type="text" name="selling_price" value="{{ $product->selling_price }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Quantity</label>
                                        <input type="number" name="quantity" value="{{ $product->quantity }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Trending</label><br/>
                                        <input type="checkbox" name="trending" {{ $product->trending == '1' ? 'checked':'' }} style="width:20px; height:20px;">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Featured</label><br/>
                                        <input type="checkbox" name="featured" {{ $product->featured == '1' ? 'checked':'' }} style="width:20px; height:20px;">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Status</label><br/>
                                        <input type="checkbox" name="status" {{ $product->status == '1' ? 'checked':'' }} style="width:20px; height:20px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade border p-3" id="image-tab-pane" role="tabpanel" aria-labelledby="image-tab" tabindex="0">
                            <div class="mb-3">
                                <label>Upload Product Image</label>
                                <input type="file" name="image[]" multiple class="form-control">
                            </div>
                            <div>
                                @if ($product->productImages)
                                <div class="row">
                                    @foreach ($product->productImages as $image)
                                    <div class="col-md-2">
                                        <img src="{{ asset($image->image) }}" style="width:90px; height=90px;"
                                        class="me-4 border" alt="Img" >
                                        <a href="{{ url('admin/products-image/'.$image->id.'/delete') }}" class="d-block">Remove</a>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                    <h5>No Image Added</h5>
                                @endif
                            </div>
                        </div>

                        <div class="tab-pane fade border p-3" id="colors-tab-pane" role="tabpanel" aria-labelledby="colors-tab" tabindex="0">
                            <div class="mb-3">
                                <h4>Add Product Color</h4>
                                <label>Select Color</label>
                                <hr/>
                                <div class="row">
                                    @forelse ($colors as $color)
                                        <div class="col-md-3">
                                            <div class="p-2 border mb-3">
                                                Color: <input type="checkbox" name="colors[{{ $color->id }}]" value="{{ $color->id }}"/>
                                                {{ $color->name }}
                                                <br/>
                                                Quantity: <input type="number" name="colorquantity[{{ $color->id }}]" style="width:60px; border:1px solid"/>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-md-12">
                                            <h1>No colors founds</h1>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <div>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Color Name</th>
                                                <th>Quantity</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product->productColors as $proColor)
                                                <tr class="prod-color-tr">
                                                    <td>
                                                        @if ( $proColor->color)
                                                            {{ $proColor->color->name }}
                                                        @else
                                                            No Color Found
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="input-group mb-3" style="width:150px">
                                                            <input type="number" value="{{ $proColor->quantity }}" class="productColorQuantity form-control">
                                                            <button type="button" value="{{ $proColor->id }}" class="updateProductColorBtn btn btn-primary btn-sm text-white">Update</button>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button" value="{{ $proColor->id }}"  class="deleteProductColorBtn btn btn-danger btn-sm text-white">Delete</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="py-2 float-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- Add this script tag at the bottom of your HTML file -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Check if the success message exists
        if ($('#imageDeleteSuccess').length > 0) {
            // Hide the success message after 4000 milliseconds (4 seconds)
            setTimeout(function () {
                $('#imageDeleteSuccess').fadeOut('slow');
            }, 2500);
        }
    });
</script>
@endsection

@section('scripts')

<script>
    $(document).ready(function(){
        // Thiết lập AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        // Gọi API để giải phóng khóa khi trang được tải lại hoặc đóng
        $(window).on('beforeunload', function (event) {
            navigator.sendBeacon('{{ route('admin.products.releaseLock', ['product_id' => $product->id]) }}', new URLSearchParams({
                '_token': '{{ csrf_token() }}'
            }));
        });
    
        // Xử lý khi nhấn nút BACK
        $('.btn-danger').on('click', function (event) {
            event.preventDefault();
            fetch('{{ route('admin.products.releaseLock', ['product_id' => $product->id]) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => {
                console.log('Lock released successfully.');
                window.location.href = '{{ url('admin/products') }}';
            });
        });
    
        // Xử lý cập nhật số lượng sản phẩm màu
        $(document).on('click','.updateProductColorBtn', function(){
            var product_id ="{{ $product->id }}";
            var prod_color_id = $(this).val();
            var qty = $(this).closest('.prod-color-tr').find('.productColorQuantity').val();
    
            if(qty <= 0){
                alert('Quantity is required');
                return false;
            }
    
            var data = {
                'product_id' : product_id,
                'qty': qty
            };
    
            $.ajax({
                type: "POST",
                url: "/admin/product-color/"+prod_color_id,
                data: data,
                success: function (response) {
                    alert(response.message);
                }
            });
        });
    
        // Xử lý xóa sản phẩm màu
        $(document).on('click','.deleteProductColorBtn', function(){
            var prod_color_id = $(this).val();
            var thisClick = $(this);
    
            $.ajax({
                type: "POST",
                url: "/admin/product-color/"+prod_color_id+"/delete",
                success: function (response) {
                    thisClick.closest('.prod-color-tr').remove();
                    alert(response.message);
                }
            });
        });
    
        // Hiển thị thông báo thành công sau khi cập nhật
        if ($('#imageDeleteSuccess').length > 0) {
            setTimeout(function () {
                $('#imageDeleteSuccess').fadeOut('slow');
            }, 2500);
        }
    });
    </script>
    


@endsection
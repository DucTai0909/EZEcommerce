<div>
    <div class="py-3 py-md-5">
        <div class="container">
            {{-- @if (session()->has('message'))
                @if (session('message') == 'This Product is Added to Your Wishlist Successfully')
                    <div id="responseMessage" class="alert alert-success"><b>{{ session('message') }}</b></div>
                @else
                    <div id="responseMessage" class="alert alert-danger"><b>{{ session('message') }}</b></div>
                @endif
            @endif --}}
            <div class="row">
                <div class="col-md-5 mt-3">
                    <div class="bg-white border" wire:ignore>
                        @if ($product->productImages)
                            {{-- <img src="{{ asset($product->productImages[0]->image) }}" class="w-100" > --}}
                            <div class="exzoom" id="exzoom">
                                <!-- Images -->
                                <div class="exzoom_img_box">
                                  <ul class='exzoom_img_ul'>
                                    @foreach ($product->productImages as $itemImg)
                                        <li><img src="{{ asset($itemImg->image) }}"/></li>
                                    @endforeach
                                  </ul>
                                </div>
                                <div class="exzoom_nav"></div>
                                <!-- Nav Buttons -->
                                <p class="exzoom_btn">
                                    <a href="javascript:void(0);" class="exzoom_prev_btn"> < </a>
                                    <a href="javascript:void(0);" class="exzoom_next_btn"> > </a>
                                </p>
                            </div>
                        @else
                            No Image
                        @endif
                    </div>
                </div>
  
                <div class="col-md-7 mt-3">
                    <div class="product-view">
                        <h4 class="product-name">
                            <b>{{ $product->name }}</b>
                            <label class="label-stock bg-success">In Stock</label>
                        </h4>
                        <hr>
                        <p class="product-path">
                            <a href="{{ url('/') }}">Home</a> / <a href="{{ url('/collections/'.$category->name) }}">{{$category->name}}</a> / {{$product->name}}
                        </p>
                        <div>
                            <span class="selling-price">{{number_format($product->selling_price, 0, ',', '.')}}</span>
                            <span class="original-price">{{number_format($product->original_price, 0, ',', '.')}}</span>
                        </div>
                        <div>
                            @if ($product->productColors->count() > 0)
                                @if ($product->productColors)
                                    
                                    @foreach ($product->productColors as $colorItem)
                                        {{-- <input type="radio" name="colorSelection" 
                                            value="{{ $colorItem->id }}"/> {{ $colorItem->color->name }} --}}
                                        <label class="colorSelectionLabel {{ $productColorId == $colorItem->id ? 'active' : '' }}" 
                                            wire:click="colorSelected({{ $colorItem->id }})">
                                            {{ $colorItem->color->name }}
                                        </label>
                                    @endforeach
                                @endif
                                
                                <div>
                                    @if ($this->prodColorSelectedQuantity == 'outOfStock')
                                        <label class="btn-sm py-1 mt-2 text-white bg-danger"> Out of Stock </label>

                                    @elseif($this->prodColorSelectedQuantity > 0)
                                        <label class="btn-sm py-1 mt-2 text-white bg-success"> In Stock </label>
                                    @endif
                                </div>
                               

                            @else
                                @if ($product->quantity)
                                    <label class="btn-sm py-1 mt-2 text-white bg-success"> In Stock </label>
                                @else
                                    <label class="btn-sm py-1 mt-2 text-white bg-danger"> Out of Stock </label>
                                @endif
                            @endif

                        </div>
                        <div class="mt-2">
                            <div class="input-group">
                                <span class="btn btn1" wire:click="decrementQuantity"><i class="fa fa-minus"></i></span>
                                <input type="text" wire:model="quantityCount" value="{{ $this->quantityCount }}" readonly class="input-quantity" />
                                <span class="btn btn1" wire:click="incrementQuantity"><i class="fa fa-plus"></i></span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="button" class="btn btn1" wire:click="addToCart({{$product->id}})"> 
                                <i class="fa fa-shopping-cart"></i> Thêm Vào Giỏ Hàng
                            </button>
                            <button type="button" wire:click="addToWishList({{ $product->id }})" 
                                class="btn btn1"> 
                                <span wire:loading.remove wire:target="addToWishList">
                                    <i class="fa fa-heart"></i> Thêm Vào Yêu Thích
                                </span>
                                <span wire:loading wire:target ="addToWishList">Adding...</span>    
                            </button>
                        </div>
                        <div class="mt-3">
                            <h5 class="mb-0">Mô Tả Ngắn</h5>
                            <p>
                                {{ $product->small_description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-3">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h4>Mô Tả</h4>
                        </div>
                        <div class="card-body">
                            <p>
                                {{ $product->description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-3 py-md-5 bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <h3><b>Có Thể Bạn Sẽ Thích</b></h3>
                    <div class="underline"></div>
                </div>
                <div class="col-md-12">
                    @if ($category)
                        <div class="owl-carousel owl-theme four-carousel">
                            @foreach ($category->relatedProducts as $relatedProductItem)
                                <div class="item mb-3">
                                    <div class="product-card">
                                        <div class="product-card-img">
                                            <label class="stock bg-danger">HOT</label>

                                            @if ($relatedProductItem->productImages->count() > 0)
                                                <a href="{{ url('/collections/'.$relatedProductItem->category->slug.'/'.$relatedProductItem->slug) }}">
                                                    <img src="{{ asset($relatedProductItem->productImages[0]->image) }}" alt="{{ $relatedProductItem->name }}" class="w-100 h-100" >
                                                </a>
                                            @endif
                                        </div>
                                        <div class="product-card-body">
                                            <p class="product-brand">{{ $relatedProductItem->brand }}</p>
                                            <h5 class="product-name">
                                                <a href="{{ url('/collections/'.$relatedProductItem->category->slug.'/'.$relatedProductItem->slug) }}">
                                                    {{ $relatedProductItem->name }}
                                                </a>
                                            </h5>
                                            <div>
                                                <span class="selling-price">{{ number_format($relatedProductItem->selling_price, 0, ',', '.') }}</span>
                                                <span class="original-price">{{ number_format($relatedProductItem->original_price, 0, ',', '.') }}</span>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-2">
                            <h4>Không Có Sản Phẩm</h4>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="py-3 py-md-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <h3><b>
                        Sản Phẩm Của 
                        @if ($product)
                            {{ $product->brand }}
                        @endif
                    </b></h3>
                    <div class="underline"></div>
                </div>
                <div class="col-md-12">
                    @if ($category)
                        <div class="owl-carousel owl-theme four-carousel">
                            @foreach ($category->relatedProducts as $relatedProductItem)
                                @if ($relatedProductItem->brand == "$product->brand")
                                    <div class="item mb-3">
                                        <div class="product-card">
                                            <div class="product-card-img">
                                                <label class="stock bg-danger">HOT</label>

                                                @if ($relatedProductItem->productImages->count() > 0)
                                                    <a href="{{ url('/collections/'.$relatedProductItem->category->slug.'/'.$relatedProductItem->slug) }}">
                                                        <img src="{{ asset($relatedProductItem->productImages[0]->image) }}" alt="{{ $relatedProductItem->name }}" class="w-100 h-100" >
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="product-card-body">
                                                <p class="product-brand">{{ $relatedProductItem->brand }}</p>
                                                <h5 class="product-name">
                                                    <a href="{{ url('/collections/'.$relatedProductItem->category->slug.'/'.$relatedProductItem->slug) }}">
                                                        {{ $relatedProductItem->name }}
                                                    </a>
                                                </h5>
                                                <div>
                                                    <span class="selling-price">{{ number_format($relatedProductItem->selling_price, 0, ',', '.') }}</span>
                                                    <span class="original-price">{{ number_format($relatedProductItem->original_price, 0, ',', '.') }}</span>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                    @else
                        <div class="p-2">
                            <h4>Không Có Sản Phẩm</h4>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')

<script>
    $(function(){

        $("#exzoom").exzoom({

        // thumbnail nav options
        "navWidth": 60,
        "navHeight": 60,
        "navItemNum": 5,
        "navItemMargin": 7,
        "navBorder": 1,

        // autoplay
        "autoPlay": false,

        // autoplay interval in milliseconds
        "autoPlayTimeout": 2000
        
        });

    });

    $('.four-carousel').owlCarousel({
        loop:true,
        margin:10,
        dots:true,
        nav:false,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:4
            }
        }
    })
</script>

@endpush

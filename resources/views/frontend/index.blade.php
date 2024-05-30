@extends('layouts.app')
@section('title', 'EZ Ecommerce')

@section('content')

<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3200">
    
    <div class="carousel-inner">

        @foreach ($sliders as $key => $slider)
        <div class="carousel-item {{ $key == 0 ? 'active' :'' }}">
            @if ($slider->image)
                <img src="{{ asset($slider->image) }}" class="d-block w-100" style="height: 450px; object-fit: cover;">
            @endif
            <div class="carousel-caption d-flex align-items-center justify-content-center">
                <div class="custom-carousel-content">
                    <div>
                        <a href="#" class="btn btn-slider">
                            Get Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        @endforeach

    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="py-5 bg-whte">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h4><b>Welcome to EZ Ecommerce</b></h4>
                <div class="underline mx-auto"></div>
                <p>
                    iPhone 15 không chỉ là một chiếc điện thoại thông minh, mà còn là biểu tượng 
                    của sự đổi mới và hiện đại. Với màn hình Super Retina XDR vô cực, hình ảnh 
                    trở nên sống động và sắc nét hơn bao giờ hết. Bạn sẽ trải nghiệm tốc độ ổn định 
                    và mượt mà nhờ bộ vi xử lý tiên tiến và công nghệ 5G tiên tiến
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Trending Products --}}
<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4><b>Trending</b></h4>
                <div class="underline mb-4"></div>
            </div>
            @if ($trendingProducts)
            
            <div class="col-md-12">
                <div class="owl-carousel owl-theme four-carousel">
                    @foreach ($trendingProducts as $productItem)
                        <div class="item">
                            <div class="product-card">
                                <div class="product-card-img">
                                    <label class="stock bg-success">TREND</label>

                                    @if ($productItem->productImages->count() > 0)
                                        <a href="{{ url('/collections/'.$productItem->category->slug.'/'.$productItem->slug) }}">
                                            <img src="{{ asset($productItem->productImages[0]->image) }}" alt="{{ $productItem->name }}" class="w-100 h-100" >
                                        </a>
                                    @endif
                                </div>
                                <div class="product-card-body">
                                    <p class="product-brand">{{ $productItem->brand }}</p>
                                    <h5 class="product-name">
                                        <a href="{{ url('/collections/'.$productItem->category->slug.'/'.$productItem->slug) }}">
                                            {{ $productItem->name }}
                                        </a>
                                    </h5>
                                    <div>
                                        <span class="selling-price">{{ number_format($productItem->selling_price, 0, ',', '.') }}</span>
                                        <span class="original-price">{{ number_format($productItem->original_price, 0, ',', '.') }}</span>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="col-md-12">
                <div class="p-2">
                    <h4>No Product Availiable for {{ $category->name }}</h4>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>


{{-- New Arrivals --}}
<div class="py-5 bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4><b>Sản Phẩm Mới</b>
                    <a href="{{ url('new-arrivals') }}" class="btn btn-warning float-end">Xem Thêm</a>
                </h4>
                <div class="underline mb-4"></div>
            </div>
            @if ($newArrivalsProducts)
            
            <div class="col-md-12">
                <div class="owl-carousel owl-theme four-carousel">
                    @foreach ($newArrivalsProducts as $productItem)
                        <div class="item">
                            <div class="product-card">
                                <div class="product-card-img">
                                    <label class="stock bg-danger">NEW</label>

                                    @if ($productItem->productImages->count() > 0)
                                        <a href="{{ url('/collections/'.$productItem->category->slug.'/'.$productItem->slug) }}">
                                            <img src="{{ asset($productItem->productImages[0]->image) }}" alt="{{ $productItem->name }}" class="w-100 h-100" >
                                        </a>
                                    @endif
                                </div>
                                <div class="product-card-body">
                                    <p class="product-brand">{{ $productItem->brand }}</p>
                                    <h5 class="product-name">
                                        <a href="{{ url('/collections/'.$productItem->category->slug.'/'.$productItem->slug) }}">
                                            {{ $productItem->name }}
                                        </a>
                                    </h5>
                                    <div>
                                        <span class="selling-price">{{ number_format($productItem->selling_price, 0, ',', '.') }}</span>
                                        <span class="original-price">{{ number_format($productItem->original_price, 0, ',', '.') }}</span>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="col-md-12">
                <div class="p-2">
                    <h4>No Product Availiable for {{ $category->name }}</h4>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>


{{-- Featured Products --}}
<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4><b>Sản Phẩm Nổi Bật</b>
                    <a href="{{ url('featured-products') }}" class="btn btn-warning float-end">Xem Thêm</a>
                </h4>
                <div class="underline mb-4"></div>
            </div>
            @if ($featuredProducts)
            
            <div class="col-md-12">
                <div class="owl-carousel owl-theme four-carousel">
                    @foreach ($featuredProducts as $productItem)
                        <div class="item">
                            <div class="product-card">
                                <div class="product-card-img">
                                    <label class="stock bg-danger">HOT</label>

                                    @if ($productItem->productImages->count() > 0)
                                        <a href="{{ url('/collections/'.$productItem->category->slug.'/'.$productItem->slug) }}">
                                            <img src="{{ asset($productItem->productImages[0]->image) }}" alt="{{ $productItem->name }}" class="w-100 h-100" >
                                        </a>
                                    @endif
                                </div>
                                <div class="product-card-body">
                                    <p class="product-brand">{{ $productItem->brand }}</p>
                                    <h5 class="product-name">
                                        <a href="{{ url('/collections/'.$productItem->category->slug.'/'.$productItem->slug) }}">
                                            {{ $productItem->name }}
                                        </a>
                                    </h5>
                                    <div>
                                        <span class="selling-price">{{ number_format($productItem->selling_price, 0, ',', '.') }}</span>
                                        <span class="original-price">{{ number_format($productItem->original_price, 0, ',', '.') }}</span>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="col-md-12">
                <div class="p-2">
                    <h4>No Product Availiable for {{ $category->name }}</h4>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
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
@endsection
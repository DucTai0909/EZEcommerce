@extends('layouts.app')
@section('title', 'Kết quả tìm kiếm')

@section('content')

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h4><b>Sản Phẩm Tìm Được</b></h4>
                <div class="underline mb-4"></div>
            </div>
                @forelse ($searchProducts as $productItem)
                <div class="col-md-10">
                    <div class="product-card">

                        <div class="row">
                            <div class="col-md-3">
                                <div class="product-card-img">
                                    <label class="stock bg-danger">New</label>

                                    @if ($productItem->productImages->count() > 0)
                                        <a href="{{ url('/collections/'.$productItem->category->slug.'/'.$productItem->slug) }}">
                                            <img src="{{ asset($productItem->productImages[0]->image) }}" alt="{{ $productItem->name }}" class="w-100 h-100" >
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-9">
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
                                    <p style="height:45px; overflow:hidden">
                                        <b>Mô tả: </b> {{ $productItem->small_description }}
                                    </p>
                                    <a href="{{ url('/collections/'.$productItem->category->slug.'/'.$productItem->slug) }}" 
                                        class="btn btn-outline-primary">
                                        Xem Ngay
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                
                @empty
                    <div class="col-md-12 p-2">
                        <h4>Không Có Sản Phẩm</h4>
                    </div>
                @endforelse
               

                <div class="col-md-10">
                    {{ $searchProducts->appends(request()->input())->links() }}
                </div>
        </div>
    </div>
</div>

@endsection
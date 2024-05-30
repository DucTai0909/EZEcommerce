@extends('layouts.app')
@section('title', 'New Arrival')

@section('content')

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4><b>Sản Phẩm Tìm Kiếm</b></h4>
                <div class="underline mb-4"></div>
            </div>
                @forelse ($newArrivalsProducts as $productItem)
                    <div class="col-md-3">
                        <div class="product-card">
                            <div class="product-card-img">
                                <label class="stock bg-danger">New</label>

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
                @empty
                    <div class="col-md-12 p-2">
                        <h4>Không Có Sản Phẩm</h4>
                    </div>
                @endforelse
                <div class="text-center">
                    <a href="{{ url('collections') }}" class="btn btn-warning px-3">Xem Thêm</a>
                </div>
        </div>
    </div>
</div>

@endsection
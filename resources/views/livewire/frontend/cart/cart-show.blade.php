<div>
    <div class="py-3 py-md-5">
        <div class="container">
            <h4><b>Giỏ Hàng</b></h4>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="shopping-cart">

                        <div class="cart-header d-none d-sm-none d-mb-block d-lg-block">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4><b>Sản Phẩm</b></h4>
                                </div>
                                <div class="col-md-1">
                                    <h4><b>Giá</b></h4>
                                </div>
                                <div class="col-md-2">
                                    <h4><b>Số Lượng</b></h4>
                                </div>
                                <div class="col-md-1">
                                    <h4><b>Tổng</b></h4>
                                </div>
                                <div class="col-md-2">
                                    <h4><b>Xóa</b></h4>
                                </div>
                            </div>
                        </div>

                        @forelse ($cart as $cartItem)
                           @if ($cartItem->product)
                                <div class="cart-item">
                                    <div class="row">
                                    <div class="col-md-6 my-auto">
                                        <a href="{{ url('/collections/'.$cartItem->product->category->slug.'/'.$cartItem->product->slug) }}">
                                            <label class="product-name">
                                                @if ($cartItem->product->productImages)
                                                    <img src="{{ asset($cartItem->product->productImages[0]->image) }}" style="width: 50px; height: 50px" alt="">
                                                    {{ $cartItem->product->name }} @if ($cartItem->productColor)
                                                    ({{ $cartItem->productColor->color->name }})
                                                    @endif
                                                @else
                                                    <img src="" style="width: 50px; height: 50px" alt="">
                                                @endif 
                                            </label>
                                        </a>
                                    </div>
                                    <div class="col-md-1 my-auto">
                                        <label class="price" style="color: red"> {{ number_format($cartItem->product->selling_price, 0, ',', '.') }}</label>
                                    </div>
                                    <div class="col-md-2 col-7 my-auto">
                                        <div class="quantity">
                                            <div class="input-group">
                                                <button type="button" wire:loading.attr="disabled" wire:click="decrementQuantity({{ $cartItem->id }})" class="btn btn1"><i class="fa fa-minus"></i></button>
                                                <input type="text" value="{{ $cartItem->quantity }}" readonly class="input-quantity" />
                                                <button type="button" wire:loading.attr="disabled" wire:click="incrementQuantity({{ $cartItem->id }})" class="btn btn1"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 my-auto">
                                        <label class="price" style="color: red"> {{ number_format($cartItem->product->selling_price * $cartItem->quantity, 0, ',', '.') }}</label>
                                        @php $totalPrice += $cartItem->product->selling_price * $cartItem->quantity @endphp
                                    </div>
                                    <div class="col-md-2 col-5 my-auto">
                                        <div class="remove">
                                            <button type="button" wire:loading.attr="disabled" wire:click="removeCartItem({{ $cartItem->id }})" class="btn btn-danger btn-sm">
                                                <span wire:loading.remove wire:target="removeCartItem({{ $cartItem->id }})">
                                                    <i class="fa fa-trash"></i> Xóa
                                                </span>
                                                <span wire:loading wire:target="removeCartItem({{ $cartItem->id }})">
                                                    <i class="fa fa-trash"></i> Đang Xóa
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                           @endif 
                        @empty
                            <div>Giỏ hàng không có sản phẩm</div>
                        @endforelse
                         
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 my-md-auto mt-3">
                    <h4>
                        Tìm sản phẩm phù hợp với mức giá hợp lý nhất <a href="{{ url('/collections') }}">Mua Ngay</a>
                    </h4>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="shadow-sm bg-white p-3">
                        <h4><b>Tổng:
                            <span class="float-end" style="color: red">{{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </b></h4>
                        <hr>
                        <a href="{{ url('/checkout') }}" @if ($cart->count() == 0) style="pointer-events: none" @endif class="btn btn-warning w-100">Đặt Hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

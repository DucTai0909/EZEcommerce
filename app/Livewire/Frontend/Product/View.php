<?php

namespace App\Livewire\Frontend\Product;

use App\Models\Cart;
use Livewire\Component;
use App\Models\Wishlist;
use Livewire\Attributes\On; 
use Illuminate\Support\Facades\Auth;


class View extends Component
{
    public $category, $product, $prodColorSelectedQuantity, $quantityCount =1, $productColorId;

    public function colorSelected($productColorId){
        $this->productColorId = $productColorId;
        $productColor =$this->product->productColors()->where('id', $productColorId)->first();
        $this->prodColorSelectedQuantity = $productColor->quantity;

        if($this->prodColorSelectedQuantity == 0){
            $this->prodColorSelectedQuantity = 'outOfStock';
        }
    }

    public function mount($category, $product){
        $this->category = $category;
        $this->product = $product;
    }
    public function render()
    {
        return view('livewire.frontend.product.view', [
            'category' => $this->category,
            'product' => $this->product,
        ]);
    }

    public function addToWishList($productId){
        if(Auth::check()){
            if(Wishlist::where('user_id', auth()->user()->id)->where('product_id', $productId)->exists()){
                $this->dispatch('message', 
                        message: 'This Product is Already Added to Your Wishlist',
                        type:'error');
                return false;
            }else{
                $wishlist = Wishlist::create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $productId
                ]);

                $this->dispatch('wishlistAddedUpdated');
                $this->dispatch('message', 
                        message: 'Added to Your Wishlist Successfully',
                        type:'success');
            }
        }else{
            // session()->flash('message', 'Please Login To Continue');
            $this->dispatch('message', 
                    message: 'Please Login To Continue',
                    type:'error');
            return false;
        }
    }

    public function decrementQuantity(){
        if($this->quantityCount > 0){
            $this->quantityCount--;
        }
    }

    public function incrementQuantity(){
        $this->quantityCount++;
    }

    public function addToCart($productId){
        if(Auth::check()){
            if($this->product->where('id', $productId)->where('status', '0')->exists()){
                if($this->product->productColors()->count() > 1){
                    // TH: sản phẩm có nhiều màu
                    if($this->prodColorSelectedQuantity != NULL){
                        if(Cart::where('user_id', auth()->user()->id)
                                ->where('product_id', $productId)
                                ->where('product_color_id', $this->productColorId)
                                ->exists()){
                            $this->dispatch('message', 
                                message: 'This Product Already Added',
                                type:'error');
                            return false;

                        }else{

                            $productColor = $this->product->productColors()
                                                            ->where('id', $this->productColorId)
                                                            ->first();
                            if($productColor->quantity > 0){
                                // Số lượng được chọn không thể lớn hơn số lượng tồn kho
                                if($productColor->quantity > $this->quantityCount){
                                    // Thêm vào giỏ hàng
                                    Cart::create([
                                            'user_id' => auth()->user()->id,
                                            'product_id' => $productId,
                                            'product_color_id' => $this->productColorId,
                                            'quantity' =>$this->quantityCount ]);
                                    $this->dispatch('CartAddedUpdated');
                                    $this->dispatch('message', 
                                        message: 'Add to Cart Successfully',
                                        type:'success');
                                    return false;
                                }else{
                                    $this->dispatch('message', 
                                            message: 'Only '. $productColor->quantity.' item for this color',
                                            type:'error');
                                    return false;
                                }
                            }else{
                                $this->dispatch('message', 
                                    message: 'Out of stock',
                                    type:'error');
                            return false;
                            }
                        }

                    }else{
                        $this->dispatch('message', 
                                message: 'Please select color',
                                type:'error');
                        return false;
                    }

                }else{
                    // TH: sản phẩm có 1 màu hoặc không có màu
                    if(Cart::where('user_id', auth()->user()->id)->where('product_id', $productId)->exists()){
                        $this->dispatch('message', 
                                message: 'This Product Already Added',
                                type:'error');
                        return false;
                    }else{
                        if($this->product->quantity >0){
                            // Đảm bảo rằng số lượng chọn không thể lớn hơn được số lượng tồn kho
                            if($this->product->quantity > $this->quantityCount){
                                // Thêm vào giỏ hàng
                                Cart::create([
                                    'user_id' => auth()->user()->id,
                                    'product_id' => $productId,
                                    'quantity' =>$this->quantityCount ]);
                                $this->dispatch('CartAddedUpdated');
                                $this->dispatch('message', 
                                    message: 'Add to Cart Successfully',
                                    type:'success');
                                return false;
                            }
                        }else{
                            $this->dispatch('message', 
                                message: 'Only'. $this->product->quantity.' Quantity Avaliable',
                                type:'error');
                            return false;
                        }
                    }    
                }
                
            }else{
                $this->dispatch('message', 
                        message: 'Product does not exists',
                        type:'error');
                return false;
            }
        }else{
            $this->dispatch('message', 
                    message: 'Please Login To Continue',
                    type:'error');
            return false;
        }
    }
}
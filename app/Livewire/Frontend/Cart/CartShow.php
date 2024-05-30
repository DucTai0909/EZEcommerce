<?php

namespace App\Livewire\Frontend\Cart;

use App\Models\Cart;
use Livewire\Component;

class CartShow extends Component
{   
    public $cart, $totalPrice = 0;
    
    public function render()
    {
        $this->cart = Cart::where('user_id', auth()->user()->id)->get();
        return view('livewire.frontend.cart.cart-show', [
            'cart' => $this->cart
        ]);
    }

    public function decrementQuantity($cartId){
        $cartData = Cart::where('id', $cartId)->where('user_id', auth()->user()->id)->first();
        if($cartData){
            if($cartData->quantity > 1){
                $cartData->decrement('quantity');
                $this->dispatch('message', 
                        message: 'Quantity Updated',
                        type:'success');
            }else{
                $this->dispatch('message', 
                    message: 'The Quantity atleast greater than 0',
                    type:'error');
            }
        }else{
            $this->dispatch('message', 
                    message: 'Something Went Wrong',
                    type:'error');
        }
    }
    
    public function incrementQuantity($cartId){
        $cartData = Cart::where('id', $cartId)->where('user_id', auth()->user()->id)->first();
        if($cartData){
            if($cartData->productColor()->where('id', $cartData->product_color_id)->exists()){
                $productColor = $cartData->productColor()
                                        ->where('id', $cartData->product_color_id)
                                        ->first();
                if($productColor->quantity > $cartData->quantity){
                    $cartData->increment('quantity', 1);
                    $this->dispatch('message', 
                        message: 'Quantity Updated',
                        type:'success');
                }else{
                    $this->dispatch('message', 
                        message: 'Only '.$productColor->quantity.' Quantity Avaliable',
                        type:'error');
                }

            }else{
                if($cartData->product->quantity > $cartData->quantity){
                    $cartData->increment('quantity', 1);
                    $this->dispatch('message', 
                            message: 'Quantity Updated',
                            type:'success');
                }else{
                    $this->dispatch('message', 
                        message: 'Only '.$cartData->product->quantity.' Quantity Avaliable',
                        type:'error');
                }
            }
            
        }else{
            $this->dispatch('message', 
                    message: 'Something Went Wrong',
                    type:'error');
        }
    }

    public function removeCartItem($cartId){
        $cartRemoveData = Cart::where('user_id', auth()->user()->id)
                ->where('id', $cartId)
                ->first();
        if($cartRemoveData){
            $cartRemoveData->delete();
            $this->dispatch('CartAddedUpdated');
            $this->dispatch('message', 
                        message: 'Cart Item Removed Successfully',
                        type:'success');
        }else{
            $this->dispatch('message', 
                        message: 'Something Went Wrong',
                        type:'error');
        }
    }
}

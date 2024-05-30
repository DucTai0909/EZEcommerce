<?php

namespace App\Livewire\Frontend;

use App\Models\Wishlist;
use Livewire\Component;

class WishListShow extends Component
{

    public function removeWishlistItem($wishlistId){
        Wishlist::where('id', $wishlistId)
                            ->where('user_id', auth()->user()->id)
                            ->delete();
        $this->dispatch('wishlistAddedUpdated');
        $this->dispatch('message', 
            message: 'Wishlist item Removed Successfully',
            type:'success');

    }

    public function render()
    {
        $wishlist = Wishlist::where('user_id', auth()->user()->id)->get();

        return view('livewire.frontend.wishlist-show', [
            'wishlist' => $wishlist
        ]);
    }
}

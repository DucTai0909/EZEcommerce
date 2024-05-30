<?php

namespace App\Livewire\Frontend\Checkout;

use App\Models\Cart;
use App\Models\Order;
use Livewire\Component;
use App\Models\Orderitem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\PlaceOrderMailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class CheckoutShow extends Component
{
    public $carts, $totalProductAmount =0;

    public $fullname, $email, $phone, $pincode, $address, $payment_mode =NULL , $payment_id =NULL, $redirect;



    public function rules(){
        return [
            'fullname' => 'required|string|max:121',
            'email' => 'required|email|max:121',
            'phone' => 'required|string|max:11|min:10',
            'pincode' => 'required|string|max:6|min:6',
            'address' => 'required|string|max:500',
        ];
    }

    public function placeOrder(){
        $this->validate();
        $order = Order::create([
            'user_id' =>auth()->user()->id,
            'tracking_no' =>'DT-'.Str::random(10),
            'fullname' =>$this->fullname,
            'email'=>$this->email,
            'phone'=>$this->phone,
            'address'=>$this->address,
            'status_message' =>'in progress',
            'payment_mode' =>$this->payment_mode,
            'payment_id' =>$this->payment_id,
            'total' => $this->totalProductAmount(),
        ]);
        
        foreach($this->carts as $cartItem){
            $orderItems = Orderitem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'product_color_id' =>$cartItem->product_color_id,
                'quantity'=>$cartItem->quantity,
                'price' =>$cartItem->product->selling_price
            ]);
            if($cartItem->product_color_id !=NULL){
                $cartItem->productColor()
                            ->where('id', $cartItem->product_color_id)
                            ->decrement('quantity', $cartItem->quantity);
            }else{
                $cartItem->product()
                            ->where('id', $cartItem->product_id)
                            ->decrement('quantity', $cartItem->quantity);
            }
        }

        return $order;
        
    }

    public function placeOrderOracle(){
        $this->validate();
    
        // Gọi procedure add_order để thêm đơn hàng vào bảng Orders
        DB::statement('
            DECLARE
                v_order_id NUMBER;
            BEGIN
                sp_add_order(:user_id, :fullname, :email, :phone, :address, :status_message, :payment_mode, :payment_id, :total, v_order_id);
            END;', [
            'user_id' => auth()->user()->id,
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'status_message' => 'in progress',
            'payment_mode' => $this->payment_mode,
            'payment_id' => $this->payment_id,
            'total' => $this->totalProductAmount(),
        ]);
    
        // Truy vấn để lấy order_id vừa được tạo
        
        $orderId = DB::table('ORDERS')
            ->where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->first()
            ->id;

    
        // Gọi procedure add_order_item để thêm mục hàng vào bảng Order_Items
        foreach ($this->carts as $item) {
            DB::statement('
                BEGIN
                    sp_add_order_item(:order_id, :product_id, :product_color_id, :quantity, :price);
                END;', [
                'order_id' => $orderId,
                'product_id' => $item->product_id,
                'product_color_id' => $item->product_color_id,
                'quantity' => $item->quantity,
                'price' => $item->product->selling_price,
            ]);
        }
    
        return $orderId;
    }

    public function codOrder(){
        $this->payment_mode = 'COD';
        // $codOrder = $this->placeOrder();
        $codOrder = $this->placeOrderOracle();

        if($codOrder){
            Cart::where('user_id', auth()->user()->id)->delete();

            try{
                 // Send Email to Customer Email
                 $order = Order::findOrFail($codOrder->id);
                 Mail::to("$order->email")->send(new PlaceOrderMailable($order));
            }catch(\Exception $e){

            }

            $this->dispatch('CartAddedUpdated');
            $this->dispatch('message', 
                        message: 'Order Successfully',
                        type:'success');
            
                        return redirect()->to('thank-you');
        }else{
            $this->dispatch('message', 
                    message: 'Something Went Wrong',
                    type:'error');
    }
    }



    public function totalProductAmount(){
        $this->totalProductAmount =0;
        $this->carts = Cart::where('user_id', auth()->user()->id)->get();
        foreach($this->carts as $cartItem){
            $this->totalProductAmount += $cartItem->product->selling_price * $cartItem->quantity;
        }

        return $this->totalProductAmount;
    }
    // public function render()
    // {
    //     $this->fullname = auth()->user()->name;
    //     $this->email = auth()->user()->email;
        
    //     $this->phone = auth()->user()->userDetail->phone;
    //     $this->pincode = auth()->user()->userDetail->pin_code;
    //     $this->address = auth()->user()->userDetail->address;


    //     $this->totalProductAmount= $this->totalProductAmount();
    //     return view('livewire.frontend.checkout.checkout-show', [
    //         'totalProductAmount' => $this->totalProductAmount
    //     ]);
    // }
    public function render(){
        $this->fullname = auth()->user()->name;
        $this->email = auth()->user()->email;

        if (auth()->user()->userDetail) {
            $this->phone = auth()->user()->userDetail->phone;
            $this->pincode = auth()->user()->userDetail->pin_code;
            $this->address = auth()->user()->userDetail->address;
        }

        $this->totalProductAmount= $this->totalProductAmount();
        return view('livewire.frontend.checkout.checkout-show', [
            'totalProductAmount' => $this->totalProductAmount
        ]);
    }
}

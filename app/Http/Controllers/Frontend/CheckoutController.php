<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Orderitem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\PlaceOrderMailable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public $carts, $totalProductAmount =0;
    public $fullname, $email='', $phone='', $pincode='', $address='', $payment_mode =NULL , $payment_id =NULL, $redirect;

    public function index(){
        return view('frontend.checkout.index');
    }

    public function vnPay(Request $request){
        // $this->takeInput($request);
        $request->flash();
        $this->totalProductAmount= $this->totalProductAmount();

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = url('/thank-you/vnpay/result');
        $vnp_TmnCode = "09Q4T7WI";//Mã website tại VNPAY 
        $vnp_HashSecret = "VLZHJQHZTRUAVPVGKXUCELPAXEXTLMBU"; //Chuỗi bí mật

        $vnp_TxnRef = 'DT'.Carbon::now(); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $this->totalProductAmount * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        // $vnp_ExpireDate = $_POST['txtexpire'];
        //Billing
        
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            
        
        return redirect($vnp_Url);
    }

    public function takeInput(Request $request){
        $this->fullname = $request->fullname1;
        dd($this->fullname);
        $this->email = $request->email1;
        
        $this->phone = $request->phone1;
        $this->pincode = $request->pincode1;
        $this->address = $request->address1;

        $this->totalProductAmount= $this->totalProductAmount();

    }

    public function totalProductAmount(){
        $this->totalProductAmount =0;
        $this->carts = Cart::where('user_id', auth()->user()->id)->get();
        foreach($this->carts as $cartItem){
            $this->totalProductAmount += $cartItem->product->selling_price * $cartItem->quantity;
        }

        return $this->totalProductAmount;
    }

    public function vnPayResult(Request $request){
        $flashedData = $request->session()->get('_old_input');

        $this->fullname = $flashedData['fullname1'] ?? '';
        $this->email = $flashedData['email1'] ?? '';
        $this->phone = $flashedData['phone1'] ?? '';
        $this->pincode = $flashedData['pincode1'] ?? '';
        $this->address = $flashedData['address1'] ?? '';

        $this->totalProductAmount= $this->totalProductAmount();

        $url = session('url_prev','/');
        if($request->vnp_ResponseCode == "00") {
            $this->payment_mode = 'VN Pay';
            $codOrder = $this->placeOrder();
            if($codOrder){
                Cart::where('user_id', auth()->user()->id)->delete();

        try{
            // Send Email to Customer Email
            $order = Order::findOrFail($codOrder->id);
            Mail::to("$order->email")->send(new PlaceOrderMailable($order));
        }catch(\Exception $e){

        }

       
                    return redirect('thank-you');
        }else{
            $this->dispatch('message', 
                    message: 'Something Went Wrong',
                    type:'error');
        }
        }
        
    }


    public function placeOrder(){
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
}

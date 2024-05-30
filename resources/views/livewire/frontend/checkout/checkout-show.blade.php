<div>
    <div class="py-3 py-md-4 checkout">
        <div class="container">
            <h4><b>Thông Tin Đặt Hàng</b></h4>
            <hr>

            @if ($this->totalProductAmount != '0')
                
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="shadow bg-white p-3">
                        <h4 class="text-primary">
                            Tổng Tiền Sản Phẩm :
                            <span class="float-end" style="color: red"><b>{{ number_format($this->totalProductAmount, 0, ',', '.') }} đ</b></span>
                        </h4>
                        <hr>
                        <small>* Thời gian giao hàng khoảng từ 2 ngày (TPHCM) và 5-7 ngày (khu vực khác).</small>
                        <br/>
                        <small>* Đã bao gồm thuế và phụ thu</small>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="shadow bg-white p-3">
                        <h4 class="text-primary">
                            Thông Tin Liên Hệ
                        </h4>
                        <hr>

                        <form action="{{ url('thank-you/vnpay') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Họ và Tên</label>
                                    <input type="text" name="fullname1" wire:model.defer="fullname"  id="fullname" class="form-control" placeholder="Enter Full Name" />
                                    @error('fullname') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Số Điện Thoại</label>
                                    <input type="number" wire:model.defer="phone" name="phone1" id="phone" class="form-control" placeholder="Enter Phone Number" />
                                    @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Email</label>
                                    <input type="email" wire:model.defer="email" name="email1" id="email" class="form-control" placeholder="Enter Email Address" />
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Pin-code (Zip-code)</label>
                                    <input type="number" wire:model.defer="pincode" name="pincode1" id="pincode" class="form-control" placeholder="Enter Pin-code" />
                                    @error('pincode') <small class="text-danger">{{ $message }}</small> @enderror

                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Địa Chỉ Nhận Hàng</label>
                                    <textarea wire:model.defer="address" id="address" name="address1" class="form-control" rows="2"></textarea>
                                    @error('address') <small class="text-danger">{{ $message }}</small> @enderror

                                </div>
                                <div class="col-md-12 mb-3" wire:ignore>
                                    <label>Chọn Phương Thức Thanh Toán: </label>
                                    <div class="d-md-flex align-items-start">
                                        <div class="nav col-md-3 flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                            <button wire:loading.attr="disabled" class="nav-link active fw-bold" id="cashOnDeliveryTab-tab" data-bs-toggle="pill" data-bs-target="#cashOnDeliveryTab" type="button" role="tab" aria-controls="cashOnDeliveryTab" aria-selected="true">Thanh Toán Khi Nhận Hàng</button>
                                            <button wire:loading.attr="disabled" class="nav-link fw-bold" id="onlinePayment-tab" data-bs-toggle="pill" data-bs-target="#onlinePayment" type="button" role="tab" aria-controls="onlinePayment" aria-selected="false">Thanh Toán Online</button>
                                        </div>
                                        <div class="tab-content col-md-9" id="v-pills-tabContent">
                                            <div class="tab-pane active show fade" id="cashOnDeliveryTab" role="tabpanel" aria-labelledby="cashOnDeliveryTab-tab" tabindex="0">
                                                <h6>Thanh Toán Khi Nhận Hàng</h6>
                                                <hr/>
                                                <button type="button" wire:loading.attr="disabled" wire:click="codOrder" class="btn btn-primary">
                                                    <span wire:loading.remove wire:target="codOrder">
                                                        Đặt Hàng (COD)
                                                    </span>
                                                    <span wire:loading wire:target="codOrder">
                                                        Đang Đặt Hàng
                                                    </span>
                                                </button>

                                            </div>
                                            <div class="tab-pane fade" id="onlinePayment" role="tabpanel" aria-labelledby="onlinePayment-tab" tabindex="0">
                                                <h6>Online Payment Mode</h6>
                                                <hr/>
                                                <button type="submit" wire:loading.attr="disabled" name="redirect" class="btn btn-warning">
                                                    <span wire:loading.remove>
                                                        Đặt Hàng (Online)
                                                    </span>
                                                    <span wire:loading>
                                                        Đang Đặt Hàng
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
            @else
                <div class="card card-body shadow text-center p-md-5">
                    <h4>Không có sản phẩm</h4>
                    <a href="{{ url('/collections') }}" class="btn btn-warning">Mua Ngay</a>
                </div>
            @endif
        </div>
    </div>

</div>

@push('scripts')
    
<script src="https://www.paypal.com/sdk/js?client-id=ATDMZOMelE-8Arb0_qX1aXsdBNCU0ZUNsmp7MgPVIVPNu75DLKWkv_qM8iGKE84n6Iy_AfbwbWiqH_o8&currency=VND"></script>
{{-- <script>
    window.paypal
    .Buttons({
        onClick()  {

            // Show a validation error if the checkbox is not checked
            if (!document.getElementById('fullname').value
                || !document.getElementById('phone').value
                || !document.getElementById('email').value
                || !document.getElementById('pincode').value
                || !document.getElementById('address').value
            ) {
                Livewire.dispatch('validationForAll');
                return false;
            }else{
                @this.set('fullname', document.getElementById('fullname').value);
                @this.set('email', document.getElementById('email').value);
                @this.set('phone', document.getElementById('phone').value);
                @this.set('pincode', document.getElementById('pincode').value);
                @this.set('address', document.getElementById('address').value);


            }
        },
        async createOrder() {
        try {
            const response = await fetch("/api/orders", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            // use the "body" param to optionally pass additional order information
            // like product ids and quantities
            body: JSON.stringify({
                cart: [
                {
                    id: "YOUR_PRODUCT_ID",
                    quantity: "YOUR_PRODUCT_QUANTITY",
                },
                ],
            }),
            });
            
            const orderData = await response.json();
            
            if (orderData.id) {
            return orderData.id;
            } else {
            const errorDetail = orderData?.details?.[0];
            const errorMessage = errorDetail
                ? `${errorDetail.issue} ${errorDetail.description} (${orderData.debug_id})`
                : JSON.stringify(orderData);
            
            throw new Error(errorMessage);
            }
        } catch (error) {
            console.error(error);
            resultMessage(`Could not initiate PayPal Checkout...<br><br>${error}`);
        }
        },
        async onApprove(data, actions) {
        try {
            const response = await fetch(`/api/orders/${data.orderID}/capture`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            });
            
            const orderData = await response.json();
            // Three cases to handle:
            //   (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
            //   (2) Other non-recoverable errors -> Show a failure message
            //   (3) Successful transaction -> Show confirmation or thank you message
            
            const errorDetail = orderData?.details?.[0];
            
            if (errorDetail?.issue === "INSTRUMENT_DECLINED") {
            // (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
            // recoverable state, per https://developer.paypal.com/docs/checkout/standard/customize/handle-funding-failures/
            return actions.restart();
            } else if (errorDetail) {
            // (2) Other non-recoverable errors -> Show a failure message
            throw new Error(`${errorDetail.description} (${orderData.debug_id})`);
            } else if (!orderData.purchase_units) {
            throw new Error(JSON.stringify(orderData));
            } else {
            // (3) Successful transaction -> Show confirmation or thank you message
            // Or go to another URL:  actions.redirect('thank_you.html');
            const transaction =
                orderData?.purchase_units?.[0]?.payments?.captures?.[0] ||
                orderData?.purchase_units?.[0]?.payments?.authorizations?.[0];
            resultMessage(
                `Transaction ${transaction.status}: ${transaction.id}<br><br>See console for all available details`,
            );
            console.log(
                "Capture result",
                orderData,
                JSON.stringify(orderData, null, 2),
            );
            }
        } catch (error) {
            console.error(error);
            resultMessage(
            `Sorry, your transaction could not be processed...<br><br>${error}`,
            );
        }
        },
    })
    .render("#paypal-button-container");
    
    // Example function to show a result to the user. Your site's UI library can be used instead.
    function resultMessage(message) {
    const container = document.querySelector("#result-message");
    container.innerHTML = message;
    }
</script> --}}
    
@endpush
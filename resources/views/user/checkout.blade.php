@extends('layouts.user')
@section('content')
    <div class="cart-box-main">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-6 mb-3">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="odr-box">
                                <div class="title-left">
                                    <h3>Sản phẩm</h3>
                                </div>
                                <div class="rounded p-2 bg-light">
                                    @foreach ($carts as $cart)
                                        <div class="media mb-2 border-bottom">
                                            <div class="media-body"> <a href="#"> {{ $cart->product->name_product }}</a>
                                                <div class="small text-muted">Giá: {{ $cart->product->price_product }}
                                                    <span class="mx-2">|</span> Sl: {{ $cart->quantity }}
                                                    <span class="mx-2">|</span> Tổng: {{ $cart->total_money }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12">
                            <div class="order-box">
                                <div class="title-left">
                                    <h3>Hóa đơn</h3>
                                </div>
                                <div class="d-flex">
                                    <div class="font-weight-bold">Sản phẩm</div>
                                    <div class="ml-auto font-weight-bold">Total</div>
                                </div>
                                <hr class="my-1">
                                <div class="d-flex">
                                    <h4>Tổng tiền</h4>
                                    <div class="ml-auto font-weight-bold"> {{ $subtotal }} </div>
                                </div>
                                <div class="d-flex">
                                    <h4>Giảm giá</h4>
                                    <div class="ml-auto font-weight-bold"> {{ $discount }} </div>
                                </div>
                                <hr class="my-1">
                                <div class="d-flex gr-total">
                                    <h5>Phải trả</h5>
                                    <div class="ml-auto h5"> {{ $payment }} </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6 mb-3">
                    <div class="checkout-address">
                        <div class="title-left">
                            <h3>Thông tin đơn hàng</h3>
                        </div>
                        <form class="needs-validation" action="{{ route('Checkout') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fullname">Tên khách hàng *</label>
                                    <input type="text" class="form-control" id="fullname" placeholder=""
                                        value="{{ $info->name }}" name="name" required>
                                    <div class="invalid-feedback"> Valid first name is required. </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email">Email *</label>
                                <input type="email" class="form-control" id="email" placeholder="" disabled
                                    value="{{ $info->email }}">
                                <div class="invalid-feedback"> Please enter a valid email address for shipping updates.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="phone">Điện thoại *</label>
                                <input type="text" class="form-control" id="phone" placeholder="" name="phone" required>
                                <div class="invalid-feedback"> Please enter a valid phone number for shipping updates.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="address">Address *</label>
                                <input type="text" class="form-control" id="address" placeholder="" name="address"
                                    value="{{ $info->address }}" required>
                                <div class="invalid-feedback"> Please enter your shipping address. </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label for="country">Thành phố *</label>
                                    <select class="wide w-100" id="country">
                                        <option value="Choose..." data-display="Select">Choose...</option>
                                        <option value="United States">TP. Hồ Chí Minh</option>
                                    </select>
                                    <div class="invalid-feedback"> Please select a valid country. </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="state">Quận *</label>
                                    <select class="wide w-100" id="state">
                                        <option data-display="Select">Choose...</option>
                                        <option>Quận 1</option>
                                        <option>Quận 2</option>
                                        <option>Quận 3</option>
                                        <option>Quận 4</option>
                                        <option>Quận 5</option>
                                        <option>Quận 6</option>
                                        <option>Quận 7</option>
                                        <option>Quận 8</option>
                                        <option>Quận 9</option>
                                        <option>Quận 10</option>
                                        <option>Quận 11</option>
                                        <option>Quận 12</option>
                                    </select>
                                    <div class="invalid-feedback"> Please provide a valid state. </div>
                                </div>
                            </div>
                            <hr class="mb-4">

                            <hr class="mb-4">
                            <div class="title"> <span>Thanh toán</span> </div>
                            <div class="d-block my-3">
                                <div class="custom-control custom-radio">
                                    <input id="credit" name="paymentMethod" type="radio" class="custom-control-input"
                                        checked required>
                                    <label class="custom-control-label" for="credit">Trực tiếp</label>
                                </div>
                            </div>

                            <hr class="mb-1">
                            <input class="ml-auto btn hvr-hover" type="submit" value="Đặt hàng">
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End Cart -->
@endsection

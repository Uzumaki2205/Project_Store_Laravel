@extends('layouts.user')
@section('content')
<!-- Start Cart  -->
<div class="cart-box-main">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-lg-6 mb-3">
                <div class="checkout-address">
                    <div class="title-left">
                        <h3>Thông tin khách hàng</h3>
                    </div>
                    <form class="needs-validation" novalidate method="POST" action="{{ route('UpdateInfo') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name">Tên khách hàng *</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                                <div class="invalid-feedback" style="width: 100%;"> Your name is required. </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email">Email Address *</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                            <div class="invalid-feedback"> Please enter a valid email address for shipping updates.
                            </div>
                        </div>

                        <hr class="mb-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="same-address">
                            <label class="custom-control-label" for="same-address">Shipping address is the same as my
                                billing address</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="save-info">
                            <label class="custom-control-label" for="save-info">Save this information for next
                                time</label>
                        </div>
                        <hr class="mb-4">

                        <div class="col-12 d-flex shopping-box">
                            <button type="submit" style="color: white" class="ml-auto btn hvr-hover">Cập nhật thông
                                tin</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-6 col-lg-6 mb-3">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="odr-box">
                            <div class="title-left">
                                <h3>Đơn hàng đã đặt</h3>
                            </div>
                            <div class="rounded p-2 bg-light">
                                @foreach ($orders as $order)
                                <div class="media mb-2 border-bottom">
                                    <form class="media-body" action="{{ route('CancelOrder') }}" method="POST">
                                        <a href="#"> Đơn hàng</a>
                                        @csrf
                                        @foreach ($order as $item)
                                        <input type="hidden" value="{{ $item->id }}" name="id[]">
                                        <div class="small text-muted">
                                            {{ $item->name_product }} {{ $item->id }}
                                            <span class="mx-2">|</span> Giá: {{ $item->price_product }}
                                            <span class="mx-2">|</span> Sl: {{ $item->quantity }}
                                            <span class="mx-2">|</span> Tổng: {{ $item->total_money }}
                                        </div>
                                        @endforeach
                                        <button type="submit" style="float: right"><i class="fas fa-times"></i></button>
                                    </form>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- End Cart -->
@endsection
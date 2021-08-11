@extends('layouts.user')
@section('script')
    <script>
        $(document).on('click', '.btnUpdateCart', function() {
            // event.preventDefault();
            let href = '{{ route('UpdateCart') }}';
            let id = $(this).closest("tr").find("input[name=id]").val();
            let quantity = $(this).closest("tr").find("input[name=quantity]").val();
            $.ajax({
                url: href,
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    "quantity": quantity,
                },
                success: function(result) {
                    // console.log(result);
                    alert('Updated Successfully!!');
                    location.reload();
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                },
                timeout: 8000
            })
        });

        $(document).on('click', '.btnRemoveCart', function() {
            // event.preventDefault();
            let href = '{{ route('RemoveCart') }}';
            let id = $(this).closest("tr").find("input[name=id]").val();
            // let quantity = $(this).closest("tr").find("input[name=quantity]").val();
            $.ajax({
                url: href,
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    // "quantity": quantity,
                },
                success: function(result) {
                    //console.log(result);
                    location.reload();
                    alert('Remove Successfully!!');
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                },
                timeout: 8000
            })
        });

    </script>
@endsection
@section('slider')
    <!-- Start All Title Box -->
    <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Order</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/product">Product</a></li>
                        <li class="breadcrumb-item active">Order</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->
@endsection
@section('content')
    <!-- Start Cart  -->
    <div class="cart-box-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-main table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Images</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Update</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $cart)
                                    <tr>
                                        <td class="thumbnail-img">
                                            <a href="#">
                                                <img class="img-fluid" src="{{ asset($cart->product->image_product) }}"
                                                    alt="" />
                                            </a>
                                        </td>
                                        <td class="name-pr">
                                            <a href="#">
                                                {{ $cart->product->name_product }}
                                            </a>
                                        </td>
                                        <td class="price-pr">
                                            <p>{{ $cart->product->price_product }}</p>
                                        </td>
                                        <td class="quantity-box">
                                            <input type="number" size="4" value="{{ $cart->quantity }}" min="0" step="1"
                                                class="c-input-text qty text" name="quantity">
                                        </td>
                                        <td class="total-pr">
                                            <p>{{ $cart->total_money }}</p>
                                        </td>
                                        <td class="update-pr">
                                            <input type="hidden" value="{{ $cart->id }}" name="id">
                                            <input class="btnUpdateCart" value="Update Cart" type="button">
                                        </td>
                                        <td class="remove-pr">
                                            <a href="#" class="btnRemoveCart">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-lg-12 col-sm-12">
                    <a class="update-box" href="{{ route('ViewCheckout') }}">
                        <input value="Checkout" type="submit">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Cart -->
@endsection

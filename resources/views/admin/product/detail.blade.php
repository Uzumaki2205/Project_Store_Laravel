@extends('layouts.admin')
@section('link')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url('/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ url('/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('script')
    <script src="{{ url('/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });
        })

    </script>
    <script>
        // Change Image when clicked
        $(document).ready(function() {
            $('.product-image-thumb').on('click', function() {
                var $image_element = $(this).find('img')
                $('.product-image').prop('src', $image_element.attr('src'))
                $('.product-image-thumb.active').removeClass('active')
                $(this).addClass('active')
            })
        })

        // Change Price Input Where Select Changed
        $('#select_promotion').on('change', function() {
            console.log(this.value);
            $.ajax({
                    method: "GET",
                    url: "{{ route('product.get_promotion') }}",
                    data: {
                        id: this.value
                    }
                })
                .done(function(response) {
                    $('#input_promption').val(response.price_promotion);
                })
                .fail(function(jqXHR, textStatus) {
                    $('#input_promption').val(0);
                });
        });

    </script>
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        {{-- @foreach ($details as $detail) --}}
        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-body">
                <form class="row" method="POST" action="{{ route('admin.UpdateProduct') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $prod->id }}" />
                    <div class="col-12 col-sm-6">
                        <h3 class="d-inline-block d-sm-none">{{ $prod->name_product }}</h3>
                        <div class="col-12">
                            <img src="{{ $prod->image_product }}" class="product-image" alt="Product Image">
                        </div>
                        <div class="col-12 product-image-thumbs">
                            <div class="product-image-thumb active"><img src="{{ $prod->image_product }}"
                                    alt="Product Image"></div>
                            @foreach ($images as $image)
                                <div class="product-image-thumb"><img src="{{ $image->galery->url_image }}"
                                        alt="Product Image"></div>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <label>Choose Different Image</label>
                            <div class="select2-purple">
                                <select class="select2" multiple="multiple" name="images[]"
                                    data-placeholder="Select a State" data-dropdown-css-class="select2-purple"
                                    style="width: 100%;">
                                    @foreach ($galery as $img)
                                        <option value="{{ $img->id }}">
                                            {{ $img->url_image }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <h4>Name</h4>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="name_product"
                                value="{{ $prod->name_product }}">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-heading"></i></span>
                            </div>
                        </div>
                        <h4>Description</h4>
                        {{-- <h3 class="my-3">{{ $prod->name_product }}</h3> --}}
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="description_product"
                                value="{{ $prod->description_product }}">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-quote-right"></i></span>
                            </div>
                        </div>
                        <h4>Quantity Inventory</h4>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" min="1" name="quantity"
                                value="{{ $prod->quantity_product }}">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-heading"></i></span>
                            </div>
                        </div>
                        {{-- <p>{{ $prod->description_product }}</p> --}}
                        <div class="form-group">
                            <label for="select_promotion">Choose <code>Promotion</code></label>
                            <select class="custom-select rounded-0" id="select_promotion" name="id_promotion">
                                @foreach ($promo as $pr)
                                    @if ($pr->id == null)
                                        <option selected value="NULL">No Promotion</option>
                                    @elseif($pr->id == $prod->promotion->id)
                                        <option selected value="{{ $pr->id }}">{{ $pr->name_promotion }}</option>
                                    @else <option value="{{ $pr->id }}">{{ $pr->name_promotion }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <hr>
                        <h4 class="mt-3">Category</h4>
                        <div class="form-group">
                            <label for="exampleSelectRounded0">Choose <code>category product</code></label>
                            <select class="custom-select rounded-0" name="id_category">
                                @foreach ($cats as $cat)
                                    @if ($cat->id == $prod->category->id)
                                        <option selected value="{{ $cat->id }}">{{ $cat->name_category }}</option>
                                    @else <option value="{{ $cat->id }}">{{ $cat->name_category }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <h4>Price</h4>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="price_product"
                                value="{{ $prod->price_product }}">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="input_promption" disabled
                                value="{{ $prod->promotion->price_promotion }}">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-tags"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Thumbnail</label>
                            <select class="form-control select2bs4" style="width: 100%;" name="image_product">
                                <option selected="selected" value="{{ $prod->image_product }}" disabled>
                                    {{ $prod->image_product }}</option>
                                @foreach ($galery as $img)
                                    <option value="{{ $img->url_image }}">
                                        {{ $img->url_image }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary btn-lg btn-flat">
                                <i class="fas fa-save fa-lg mr-2"></i>
                                Save Change
                            </button>

                            <a href="/admin/products">
                                <button type="button" class="btn btn-danger btn-lg btn-flat">
                                    <i class="fas fa-undo fa-lg mr-2"></i>
                                    Back To Manager
                                </button>
                            </a>
                        </div>
                    </div>
                </form>
                <div class="row mt-4">
                    <nav class="w-100">
                        <div class="nav nav-tabs" id="product-tab" role="tablist">
                            <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc"
                                role="tab" aria-controls="product-desc" aria-selected="true">Description</a>
                            <a class="nav-item nav-link" id="product-comments-tab" data-toggle="tab"
                                href="#product-comments" role="tab" aria-controls="product-comments"
                                aria-selected="false">Comments</a>
                            <a class="nav-item nav-link" id="product-rating-tab" data-toggle="tab" href="#product-rating"
                                role="tab" aria-controls="product-rating" aria-selected="false">Rating</a>
                        </div>
                    </nav>
                    <div class="tab-content p-3" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="product-desc" role="tabpanel"
                            aria-labelledby="product-desc-tab"> Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Morbi vitae condimentum erat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices
                            posuere cubilia Curae; Sed posuere, purus at efficitur hendrerit, augue elit lacinia arcu, a
                            eleifend sem elit et nunc. Sed rutrum vestibulum est, sit amet cursus dolor fermentum vel.
                            Suspendisse mi nibh, congue et ante et, commodo mattis lacus. Duis varius finibus purus sed
                            venenatis. Vivamus varius metus quam, id dapibus velit mattis eu. Praesent et semper risus.
                            Vestibulum erat erat, condimentum at elit at, bibendum placerat orci. Nullam gravida velit
                            mauris, in pellentesque urna pellentesque viverra. Nullam non pellentesque justo, et ultricies
                            neque. Praesent vel metus rutrum, tempus erat a, rutrum ante. Quisque interdum efficitur nunc
                            vitae consectetur. Suspendisse venenatis, tortor non convallis interdum, urna mi molestie eros,
                            vel tempor justo lacus ac justo. Fusce id enim a erat fringilla sollicitudin ultrices vel metus.
                        </div>
                        <div class="tab-pane fade" id="product-comments" role="tabpanel"
                            aria-labelledby="product-comments-tab"> Vivamus rhoncus nisl sed venenatis luctus. Sed
                            condimentum risus ut tortor feugiat laoreet. Suspendisse potenti. Donec et finibus sem, ut
                            commodo lectus. Cras eget neque dignissim, placerat orci interdum, venenatis odio. Nulla turpis
                            elit, consequat eu eros ac, consectetur fringilla urna. Duis gravida ex pulvinar mauris ornare,
                            eget porttitor enim vulputate. Mauris hendrerit, massa nec aliquam cursus, ex elit euismod
                            lorem, vehicula rhoncus nisl dui sit amet eros. Nulla turpis lorem, dignissim a sapien eget,
                            ultrices venenatis dolor. Curabitur vel turpis at magna elementum hendrerit vel id dui.
                            Curabitur a ex ullamcorper, ornare velit vel, tincidunt ipsum. </div>
                        <div class="tab-pane fade" id="product-rating" role="tabpanel" aria-labelledby="product-rating-tab">
                            Cras ut ipsum ornare, aliquam ipsum non, posuere elit. In hac habitasse platea dictumst. Aenean
                            elementum leo augue, id fermentum risus efficitur vel. Nulla iaculis malesuada scelerisque.
                            Praesent vel ipsum felis. Ut molestie, purus aliquam placerat sollicitudin, mi ligula euismod
                            neque, non bibendum nibh neque et erat. Etiam dignissim aliquam ligula, aliquet feugiat nibh
                            rhoncus ut. Aliquam efficitur lacinia lacinia. Morbi ac molestie lectus, vitae hendrerit nisl.
                            Nullam metus odio, malesuada in vehicula at, consectetur nec justo. Quisque suscipit odio velit,
                            at accumsan urna vestibulum a. Proin dictum, urna ut varius consectetur, sapien justo porta
                            lectus, at mollis nisi orci et nulla. Donec pellentesque tortor vel nisl commodo ullamcorper.
                            Donec varius massa at semper posuere. Integer finibus orci vitae vehicula placerat. </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        {{-- @endforeach --}}
    </section>
    <!-- /.content -->
@endsection

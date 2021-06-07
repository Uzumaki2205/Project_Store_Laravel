@extends('layouts.admin')
@section('link')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url('/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ url('/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('script')
    <!-- Select2 -->
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
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create New Product</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <form class="card-body" accept="utf-8" method="POST" enctype="multipart/form-data"
                        action="{{ route('admin.CreateProduct') }}">
                        @csrf
                        <div class="form-group">
                            <label for="inputName">Name Product</label>
                            <input type="text" id="inputName" name="name_product" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">Description</label>
                            <textarea id="inputDescription" class="form-control" name="description_product"
                                rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="inputQuantity">Quantity</label>
                            <input type="number" id="inputQuantity" class="form-control" min="1" value="1"
                                name="quantity"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="inputStatus">Category</label>
                            <select id="inputStatus" name="id_category" class="form-control custom-select">
                                <option selected disabled>Select one</option>
                                @foreach ($cats as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name_category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputPromotion">Promotion</label>
                            <select id="inputPromotion" class="form-control custom-select" name="id_promotion">
                                <option selected disabled>Select one</option>
                                @foreach ($promo as $pr)
                                    <option value="{{ $pr->id }}">{{ $pr->name_promotion }} :
                                        {{ $pr->price_promotion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputPriceProduct">Price Product</label>
                            <input type="text" id="inputPriceProduct" class="form-control" name="price_product">
                        </div>

                        <div class="form-group">
                            <label>Thumbnail</label>
                            <select class="form-control select2bs4" style="width: 100%;" name="image_product" required>
                                <option selected="selected" disabled>Select A Link</option>
                                @foreach ($imgs as $img)
                                    <option value="{{ $img->url_image }}">
                                        {{ $img->url_image }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Choose Image</label>
                            <div class="select2-purple">
                                <select class="select2" multiple="multiple" name="images[]" required
                                    data-placeholder="Select a State" data-dropdown-css-class="select2-purple"
                                    style="width: 100%;">
                                    @foreach ($imgs as $img)
                                        <option value="{{ $img->id }}">
                                            {{ $img->url_image }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label for="inputImageUpload">Upload Image</label>
                            <input type="file" name="attachment[]" class="form-control-file" id="exampleFormControlFile1"
                                multiple>
                        </div> --}}
                        <div class="row">
                            <div class="col-12">
                                <a href="#" class="btn btn-secondary">Cancel</a>
                                <input type="submit" value="Create New Product" class="btn btn-success float-right">
                            </div>
                        </div>
                    </form>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

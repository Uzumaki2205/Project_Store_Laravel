@extends('layouts.admin')
@section('link')
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="../plugins/ekko-lightbox/ekko-lightbox.css">
@endsection
@section('script')
    <!-- Ekko Lightbox -->
    <script src="../plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
    <!-- Filterizr-->
    <script src="../plugins/filterizr/jquery.filterizr.min.js"></script>
    <script>
        $(function() {
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });

            $('#btnFilter').on('click', function() {
                $(this).attr('data-filter', $('#select_product').val());
            });

            $('.filter-container').filterizr({
                gutterPixels: 3
            });
        })

    </script>
@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4 class="card-title">Galery Lightbox</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-inline mb-4">
                                <select class="custom-select mr-2" id="select_product">
                                    <option value="all""> All items </option>                                                                                                                                               
                                              @foreach ($prods as $prod)
                                    <option value={{ $prod->id }}>
                                        {{ $prod->name_product }}
                                    </option>
                                    @endforeach
                                </select>
                                <button type="button" data-filter="1" id="btnFilter" class="btn btn-primary">
                                    Filter
                                </button>
                            </div>

                            <div>
                                <div class="filter-container p-0 row">
                                    @foreach ($imgs as $img)
                                        <div class="filtr-item col-sm-2" data-category="{{ $img->id_product }}">
                                            <a href="{{ $img->galery->url_image }}" data-toggle="lightbox"
                                                data-title="{{ $img->product->name_product }}">
                                                <img src="{{ asset($img->galery->url_image) }}" class="img-fluid mb-2"
                                                    alt="{{ $img->product->name_product }}" />
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

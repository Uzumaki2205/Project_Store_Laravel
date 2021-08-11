@extends('layouts.admin')
@section('link')
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="{{ url('/plugins/ekko-lightbox/ekko-lightbox.css') }}">
    <link rel="stylesheet" href="{{ url('/plugins/image-picker/image-picker/image-picker.css') }}">
@endsection
@section('script')
    <!-- Ekko Lightbox -->
    <script src="{{ url('/plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
    <script src="{{ url('/plugins/image-picker/image-picker/image-picker.js') }}"></script>
    <script>
        $(function() {
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });
        })

    </script>
    <script>
        $('.image-picker').imagepicker();

    </script>
@endsection
@section('content')
    <style>
        .resize {
            size: 10px;
        }

    </style>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <form method="POST" action="{{ route('admin.UploadImage') }}" enctype="multipart/form-data">
                                @csrf
                                <h4 for="inputImageUpload">Gs</h4>
                                {{-- <div class="form-group">
                                    <label for="inputImageUpload">Upload Image</label>
                                    <input type="file" name="attachment[]" class="form-control-file" multiple>
                                </div>

                                <button type="submit" class="btn btn-warning">Upload</button> --}}
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="attachment[]" multiple>
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <button class="input-group-text">Upload</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="filter-container p-0 row">
                                    @foreach ($imgs as $img)
                                        {{-- <select class="image-picker" multiple="multiple">
                                            <option value="{{ $img->id }}" data-img-src="{{ $img->url_image }}">
                                            </option>
                                        </select> --}}
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <a href="{{ $img->url_image }}" data-toggle="lightbox"
                                                    data-title="{{ $img->url_image }}">
                                                    <img src="{{ asset($img->url_image) }}" class="img-fluid mb-2"
                                                        alt="{{ $img->url_image }}" />
                                                </a>
                                                <a href="#"><button type="button"
                                                        class="btn btn-danger col-sm-12">Delete</button></a>
                                            </div>
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

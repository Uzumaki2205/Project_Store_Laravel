@extends('layouts.admin')
@section('link')
    {{-- <link rel="stylesheet" href="{{ url('/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ url('/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('script')
    <script src="{{ url('/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ url('/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false
                // ,"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            $('#btnDelProduct').click(function(event) {
                event.preventDefault();
                var val = [];
                $('.cbxId:checked').each(function(i) {
                    val[i] = $(this).attr('value');
                });

                let href = $(this).attr('data-attr');
                let token = $(this).attr('data-token');

                $.ajax({
                    url: href,
                    type: "post",
                    data: {
                        "ids": val
                    },
                    success: function(result) {
                        location.reload();
                        $('.swalDefaultSuccess').click();
                    },
                    error: function(jqXHR, testStatus, error) {
                        console.log(error)
                        $('.swalDefaultError').click()
                    },
                    timeout: 8000
                });
            });
        });

    </script>
@endsection
@section('content')
    <div class="card">
        <div class="card-header d-inline">
            <a href="{{ route('admin.showCreateForm') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add Product
            </a>
            <a class="btn btn-danger" id="btnDelProduct" data-attr="{{ route('admin.DeleteProduct') }}">
                <i class=" fa fa-trash"></i> Delete Product
            </a>
        </div>
        <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <td></td>
                        <td>Name Product</td>
                        <td>Category</td>
                        <td>Price</td>
                        <td>Promotion</td>
                        <td>Created At</td>
                        <td>Extensions</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prods as $prod)
                        <tr data-id="{{ $prod->id }}">
                            <th>
                                <input class="cbxId" type="checkbox" value="{{ $prod->id }}" />
                            </th>
                            <th>{{ $prod->name_product }}</th>
                            <th>{{ $prod->category->name_category }}</th>
                            <th>{{ $prod->price_product }}</th>
                            <th>{{ $prod->promotion->price_promotion }}</th>
                            <th>{{ $prod->created_at }}</th>
                            <th>
                                <a href="{{ route('admin.slugProduct', ['slug_product' => $prod->slug_product]) }}">
                                    <button type="submit" class="btn btn-info btn-block btn-sm">
                                        <i class="fa fa-edit"></i>Edit
                                    </button>
                                </a>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

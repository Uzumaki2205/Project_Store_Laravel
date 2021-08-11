@extends('layouts.admin')
@section('link')
    {{-- <link rel="stylesheet" href="{{ url('/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ url('/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ url('/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ url('/plugins/toastr/toastr.min.css') }}">
@endsection
@section('script')
    <script src="{{ url('/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ url('/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        $(document).on('click', '#btnEdit', function(event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            $.ajax({
                url: href,
                success: function(result) {
                    //console.log(result);
                    $("input[name='id']").val(result.id);
                    $("input[name='name_category']").val(result.name_category);
                    $('#modal-body').html(result).show();
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                },
                timeout: 8000
            })
        });

    </script>
    <script>
        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            $('.swalDefaultSuccess').click(function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Updated Success For User.'
                })
            });
            $('.swalDefaultError').click(function() {
                Toast.fire({
                    icon: 'error',
                    title: 'Update error for user.'
                })
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // PROCESS MODAL ADD AND DELETE USER
            //     $(function() {
            //         $('#btnDelCategory').click(function(event) {
            //             event.preventDefault();
            //             var val = [];
            //             $('#cbxId:checked').each(function(i) {
            //                 val[i] = $(this).attr('value');
            //             });

            //             let href = $(this).attr('data-attr');
            //             $.ajax({
            //                 url: href,
            //                 type: "post",
            //                 data: {
            //                     "ids": val
            //                 },
            //                 success: function(result) {
            //                     //console.log(result);
            //                     location.reload();
            //                     $('.swalDefaultSuccess').click();
            //                 },
            //                 error: function(jqXHR, testStatus, error) {
            //                     console.log(error)
            //                     $('.swalDefaultError').click()
            //                 },
            //                 timeout: 8000
            //             });
            //         });
            //     });
            // });
        });

    </script>

@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        {{-- <h3 class="card-title">Responsive Hover Table</h3> --}}
                        <div class="card-title d-inline">
                            <button type="button" class="btn btn-primary" id="btnAddUser"
                                data-attr="{{ route('admin.create_category') }}" data-toggle="modal"
                                data-target="#modal-add">
                                <i class="fa fa-plus"></i> Add Category
                            </button>

                        </div>

                        <button type="button" class="btn btn-success swalDefaultSuccess" style="display: none">Update
                            Successfully</button>
                        <button type="button" class="btn btn-danger swalDefaultError" style="display: none">Update
                            Error</button>
                        <div class="card-tools d-inline-block">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                    placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cats as $cat)
                                    <tr>
                                        <td>
                                            <input type="checkbox" id="cbxId" value="{{ $cat->id }}" />
                                        </td>
                                        <td>{{ $cat->id }}</td>
                                        <td>{{ $cat->name_category }}</td>
                                        <td>{{ $cat->slug_category }}</td>
                                        <td>{{ $cat->created_at }}</td>
                                        <td>
                                            <button type="submit" class="btn btn-info btn-block btn-sm" data-toggle="modal"
                                                data-target="#modal-default" id="btnEdit"
                                                data-attr="{{ route('admin.edit_category', ['id' => $cat->id]) }}">
                                                <i class="fa fa-user-edit"></i>Edit
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->

                    {{-- Modal Edit User --}}
                    <form method="POST" action="{{ route('admin.UpdateCategory') }}">
                        @csrf
                        <div class="modal fade" id="modal-default">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit Category</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id" />
                                        <div class="form-group">
                                            <label for="name_category">Name</label>
                                            <input type="text" class="form-control" name="name_category"
                                                placeholder="Enter name">
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" id="btnCloseModal"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" id="btnSaveEdit">Save
                                            changes</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    </form>
                    {{-- End Modal Edit User --}}

                    {{-- Add User Modal --}}
                    <form method="POST" action="{{ route('admin.create_category') }}">
                        @csrf
                        <div class="modal fade" id="modal-add">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Add Category</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="col-form-label" for="category">Name</label>
                                            <input type="text" class="form-control" name="name_category"
                                                placeholder="Enter Name Cateogory">
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" id="adduser">Add</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    </form>
                    {{-- End Add User Modal --}}

                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div>
@endsection

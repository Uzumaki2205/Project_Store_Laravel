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
                $("input[name='name_promotion']").val(result.name_promotion);
                $("input[name='price_promotion']").val(result.price_promotion);
                $("input[name='start_date']").val(result.start_date);
                $("input[name='end_date']").val(result.end_date);
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
                title: 'Updated Success.'
            })
        });
        $('.swalDefaultError').click(function() {
            Toast.fire({
                icon: 'error',
                title: 'Update error.'
            })
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '#btnSaveEdit', function(event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            let id = $("input[name='id']").val();
            let name_promotion = $("input[name='name_promotion']").val();
            let price_promotion = $("input[name='price_promotion']").val();
            let start_date = $("input[name='start_date']").val();
            let end_date = $("input[name='end_date']").val();

            $.ajax({
                url: href,
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    "name_promotion": name_promotion,
                    "price_promotion": price_promotion,
                    "start_date": start_date,
                    "end_date": end_date,
                },
                success: function(result) {
                    location.reload();
                    $('.swalDefaultSuccess').click();
                    $('#btnCloseModal').click();
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    $('.swalDefaultError').click()
                },
                timeout: 8000
            })
        });

        // PROCESS MODAL ADD AND DELETE Promption
        $(function() {
            $('#btnDelUser').click(function(event) {
                event.preventDefault();
                var val = [];
                $('#cbxId:checked').each(function(i) {
                    val[i] = $(this).attr('value');
                });
                console.log(val);
                let href = $(this).attr('data-attr');
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

        // $("#adduser").submit(function(e) {
        // e.preventDefault();
        // var form = $(this);
        // var url = form.attr('action');

        // $.ajax({
        //     type: "POST",
        //     url: url,
        //     data: form.serialize(),
        //     success: function(data)
        //     {
        //         location.reload();
        //         $('.swalDefaultSuccess').click();
        //     },
        //     error: function(jqXHR, testStatus, error) {
        //         console.log(error)
        //         $('.swalDefaultError').click()
        //     },
        //     timeout: 8000
        // });
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
                        <button type="button" class="btn btn-primary" id="btnAddUser" data-attr="{{ route('admin.add-promotion') }}" data-toggle="modal" data-target="#modal-add">
                            <i class="fa fa-plus"></i> Add Promotion
                        </button>
                        <button type="button" class="btn btn-danger" id="btnDelUser" data-attr="{{ route('admin.delete-promotion') }}">
                            <i class="fa fa-trash"></i> Delete Promotion
                        </button>
                    </div>

                    <button type="button" class="btn btn-success swalDefaultSuccess" style="display: none">Update Successfully</button>
                    <button type="button" class="btn btn-danger swalDefaultError" style="display: none">Update Error</button>
                    <div class="card-tools d-inline-block">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

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
                                <th>Name Promotion</th>
                                <th>Price Promotion</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Extension</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($promotions as $promotion)
                            <tr>
                                <td>
                                    <input type="checkbox" id="cbxId" value="{{ $promotion->id }}" />
                                </td>
                                <td>{{ $promotion->id }}</td>
                                <td>{{ $promotion->name_promotion }}</td>
                                <td>{{ $promotion->price_promotion }}</td>
                                <td>{{ $promotion->start_date }}</td>
                                <td>{{ $promotion->end_date }}</td>
                                <td>
                                    <button type="submit" class="btn btn-info btn-block btn-sm" data-toggle="modal" data-target="#modal-default" id="btnEdit" data-attr="{{ route('admin.edit-promotion', ['id' => $promotion->id]) }}">
                                        <i class="fa fa-user-edit"></i>Edit
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->

                {{-- Modal Edit Promotion --}}
                <form method="POST" action="{{ route('admin.save-edit-promotion') }}">
                    @csrf
                    <div class="modal fade" id="modal-default">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit Promotion</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" />
                                    <div class="form-group">
                                        <label for="name">Name Promotion</label>
                                        <input type="text" class="form-control" name="name_promotion" placeholder="Enter name promotion">
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Price Promotion</label>
                                        <input type="number" class="form-control" name="price_promotion" placeholder="Enter price">
                                    </div>
                                    <div class="form-group">
                                        <label for="start date">Start Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" name="start_date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="end date">End Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" name="end_date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" id="btnCloseModal" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="btnSaveEdit" data-attr="{{ route('admin.save-edit-promotion') }}">Save changes</button>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                </form>
                {{-- End Modal Edit Promotion --}}

                {{-- Add Promotion Modal --}}
                <form method="POST" action="{{ route('admin.add-promotion') }}">
                    @csrf
                    <div class="modal fade" id="modal-add">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add Promotion</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" />
                                    <div class="form-group">
                                        <label for="name">Name Promotion</label>
                                        <input type="text" class="form-control" name="name_promotion" placeholder="Enter name promotion">
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Price Promotion</label>
                                        <input type="number" class="form-control" name="price_promotion" placeholder="Enter price">
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Start Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" name="start_date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Start Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" name="end_date" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                        </div>
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
                {{-- End Add Promotion Modal --}}

            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.row -->
</div>
@endsection
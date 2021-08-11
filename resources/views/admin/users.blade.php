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
                $("input[name='username']").val(result.username);
                $("input[name='name']").val(result.name);
                $("input[name='email']").val(result.email);
                $("select[name='is_admin']").val(result.is_admin);
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
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    
    $(document).on('click', '#btnSaveEdit', function(event) {
        event.preventDefault();
        let href = $(this).attr('data-attr');
        let id = $("input[name='id']").val();
        let name = $("input[name='name']").val();
        let username = $("input[name='username']").val();
        let password = $("input[name='password']").val();
        let email = $("input[name='email']").val();
        let is_admin = $("select[name='is_admin']").val();

        $.ajax({
            url: href,
            type: "post",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id,
                "name": name,
                "username": username,
                "password": password,
                "email": email,
                "is_admin": is_admin
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

    // PROCESS MODAL ADD AND DELETE USER
    $(function(){
      $('#btnDelUser').click(function(event){
        event.preventDefault();
        var val = [];
        $('#cbxId:checked').each(function(i){
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
                            <button type="button" class="btn btn-primary" id="btnAddUser" 
                            data-attr="{{ route('admin.add-user') }}" data-toggle="modal" data-target="#modal-add">
                                <i class="fa fa-plus"></i> Add User
                            </button>
                            <button type="button" class="btn btn-danger" id="btnDelUser" data-attr="{{ route('admin.delete-user') }}">
                                <i class="fa fa-trash"></i> Delete User
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
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Admin</th>
                                <th>Created At</th>
                                <th>Extension</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <input type="checkbox" id="cbxId" value="{{ $user->id }}"/>
                                    </td>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->is_admin == 1)
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" id="checkboxPrimary1" checked disabled>
                                                <label for="checkboxPrimary1">
                                                </label>
                                            </div>
                                        @else
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" id="checkboxPrimary1" disabled>
                                                <label for="checkboxPrimary1">
                                                </label>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>  
                                        <button type="submit" class="btn btn-info btn-block btn-sm"
                                            data-toggle="modal" data-target="#modal-default" 
                                            id="btnEdit" data-attr="{{ route('admin.edit-user', ['id' => $user->id]) }}">
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
                    <form method="POST" action="{{ route('admin.save-edit-user') }}">
                        @csrf
                        <div class="modal fade" id="modal-default">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Edit User</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id"/>
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Enter name">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" name="username" placeholder="Enter username">
                                    </div>
                                    <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control" name="email" placeholder="Enter email">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleSelectBorder">Role</label>
                                    <select class="custom-select form-control-border" name="is_admin" id="exampleSelectBorder">
                                      <option value="0">User</option>
                                      <option value="1">Admin</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" id="btnCloseModal" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary" id="btnSaveEdit" data-attr="{{ route('admin.save-edit-user') }}">Save changes</button>
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
                    <form method="POST" action="{{ route('admin.add-user') }}">
                        @csrf
                        <div class="modal fade" id="modal-add">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h4 class="modal-title">Add User</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-form-label" for="username">Username</label>
                                        <input type="text" class="form-control" name="username" placeholder="Enter username">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-form-label" for="email">Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Enter email">
                                    </div>
                                   
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Enter name">
                                    </div>
                                   
                                    <div class="form-group">
                                        <label class="col-form-label" for="password">Password</label>
                                        <input type="password" class="form-control" name="password" placeholder="Enter password">
                                    </div>
                                   
                                    <div class="form-group">
                                        <label class="col-form-label" for="repassword">RePassword</label>
                                        <input type="password" class="form-control" name="password_again" placeholder="Enter password again">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label" for="isAdmin">Role</label>
                                        <select class="form-control" name="is_admin">
                                            <option value="0">User</option>
                                            <option value="1">Admin</option>
                                          </select>
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

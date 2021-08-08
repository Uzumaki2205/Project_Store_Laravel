@extends('layouts.admin')
@section('link')
    <link rel="stylesheet" href="{{ url('/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('script')
    <script src="{{ url('/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ url('/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script>
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
        });

    </script>
@endsection
@section('content')
    <div class="card">
        <div class="card-header d-inline">
            <a class="btn btn-danger" id="btnDelUser">
                <i class="fa fa-trash"></i> Delete Order
            </a>
        </div>
        <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <td></td>
                        <td>Name Product</td>
                        <td>Group</td>
                        <td>Created At</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ocs as $oc)
                        <tr data-id="">
                            <th><input class="cbxId" type="checkbox" value="" /></th>
                            <th>
                                {{ $oc->order->name_product }}
                            </th>
                            <th>
                                {{ $oc->order->code }}
                            </th>
                            <th>
                                {{ $oc->order->created_at }}
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

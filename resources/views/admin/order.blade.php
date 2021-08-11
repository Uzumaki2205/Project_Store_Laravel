@extends('layouts.admin')
@section('link')
    <link rel="stylesheet" href="{{ url('/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
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
                        <td>Address</td>
                        <td>Created At</td>
                        <td>Payment</td>
                        <td>Extension</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <th><input class="cbxId" type="checkbox" value="" /></th>

                            <th>
                                @foreach ($order as $item)
                                    <span>
                                        {{ $item->name_product }},
                                    </span>
                                @endforeach
                            </th>
                            <th>
                                {{ $order[0]->address }}
                            </th>
                            <th>
                                {{ $order[0]->created_at }}
                            </th>
                            <th>
                                <?php $total = 0; ?>
                                @foreach ($order as $item)
                                    <?php $total = $total + $item->total_money; ?>
                                @endforeach
                                <?php echo $total; ?>
                            </th>
                            <th>
                                @if ($order[0]->accept == 0)
                                    <form action="{{ route('admin.AcceptOrder') }}" method="POST">
                                        @csrf
                                        @foreach ($order as $item)
                                            <input type="hidden" name="id[]" value="{{ $item->id }}">
                                        @endforeach

                                        <button type="submit" class="btn btn-info btn-block btn-sm">
                                            <i class="fa fa-edit"></i>ACCEPT
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.NotAcceptOrder') }}" method="POST">
                                        @csrf
                                        @foreach ($order as $item)
                                            <input type="hidden" name="id[]" value="{{ $item->id }}">
                                        @endforeach

                                        <button type="submit" class="btn btn-danger btn-block btn-sm">
                                            <i class="fa fa-edit"></i>NO ACCEPT
                                        </button>
                                    </form>
                                @endif
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

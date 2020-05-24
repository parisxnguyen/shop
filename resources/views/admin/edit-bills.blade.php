@extends('admin.master')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
@endsection
@section('header')
Edit bill-status
@endsection
@section('address')
Bill-status
@endsection
@section('main-content')
    {{--Bang liet ke cac san pham--}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">bill</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">@if(Session::has('thongbao')){{Session::get('thongbao')}}@endif</div>
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Customer</th>
                    <th>Date Order</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Note</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$customers[$bill->id]}}</td>
                        <td>{{$bill->date_order}}</td>
                        <td>{{number_format($bill->total)}}</td>
                        <td>{{$bill->payment}}</td>
                        <td>{{$bill->note}}</td>
                        <td>
                            <form method="post" action="/edit-bill/{{$bill->id}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <select name="status">
                                    <option value="0">Mới đặt hàng</option>
                                    <option value="1">Đang xử lý</option>
                                    <option value="2">Đang giao hàng</option>
                                    <option value="3">Chờ thanh toán</option>
                                    <option value="4">Đã thanh toán</option>
                                </select>
                                <input type="submit" value="Submit"/>
                            </form>
                        </td>
                    </tr>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@endsection
@section('script')
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <script>
        $(function () {
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
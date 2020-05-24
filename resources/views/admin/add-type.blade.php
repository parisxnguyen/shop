@extends('admin.master')
@section('header')
add product-type
@endsection
@section('address')
add product-type
@endsection
@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="post" enctype="multipart/form-data" action="/add-type">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="row">@if(Session::has('thongbao')){{Session::get('thongbao')}}@endif</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="product-type name">Product-type name</label>
                            <input type="text" class="form-control" id="product-type name" name="name" placeholder="Enter product-type name">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" id="product-desc" name="desc" rows="3" placeholder="Enter product-type description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Product-type image</label>
                            <div class="input-group">
                                <input type="file" name="img" required="true">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
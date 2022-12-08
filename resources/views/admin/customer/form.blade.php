@extends('admin.layout')
@section('content')
    <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">{{$title}}</h3>

                <div class="box-tools pull-right">
                    <button class="btn btn-sm btn-success"
                            onclick="document.getElementById('form-save-information').submit()">Lưu
                    </button>
                    <a href="{{route('employee.index')}}" class="btn btn-sm btn-danger">Hủy</a>
                </div>
            </div>

        </div>
        <!-- /.box -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{$action}}" id="form-save-information" method="post" enctype="multipart/form-data">
            @method($method)
            @csrf
            <div class="row">
                <div class="col-md-6">

                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Họ tên khách hàng:</label>
                                <input type="text" class="form-control" name="name" value="{{$row['name']?? old('name') ?? ''}}">
                                <!-- /.input group -->
                            </div>

                            <!-- phone mask -->
                            <div class="form-group">
                                <label>Số điện thoại:</label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input type="text" class="form-control" name="phone"
                                           value="{{$row['phone'] ?? old('phone') ?? ''}}">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->

                            <!-- phone mask -->
                            <div class="form-group">
                                <label>Email:</label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <input type="email" class="form-control" name="email"
                                           value="{{$row['email']?? old('email')  ?? ''}}">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->
                            <!-- phone mask -->
                            <div class="form-group" style="display: flex;align-items: center;">
                                <label>Giới tính:</label>
                                <div class="form-group mb-0" style="margin:0px;display: flex;">
                                    <div style="margin-left:10px; ">
                                        <label>
                                            <input type="radio" name="gender" id="boy" value="0" checked="">
                                            Nam
                                        </label>
                                    </div>
                                    <div style="margin-left:10px; ">
                                        <label>
                                            <input type="radio" name="gender"
                                                   {{!empty($row['gender']) ? 'checked' : ''}}  id="girl" value="1">
                                            Nữ
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <!-- /.form group -->

                            <!-- phone mask -->
                            <div class="form-group">
                                <label>Địa chỉ </label>
                                <textarea type="text" name="address"
                                          class="form-control">{{$row['address'] ?? old('address')  ?? ''}}</textarea>

                                <!-- /.input group -->
                            </div>


                            <!-- Date and time range -->
                            <div class="form-group" style="display: flex;align-items: center;">
                                <label>Trạng thái:</label>
                                <div class="form-group mb-0" style="margin:0px;display: flex;">
                                    <div style="margin-left:10px; ">
                                        <label>
                                            <input type="radio" name="is_status" value="1" checked="">
                                            Hoạt động
                                        </label>
                                    </div>
                                    <div style="margin-left:10px; ">
                                        <label>
                                            <input type="radio" name="is_status"
                                                   {{isset($row['is_status']) && $row['is_status'] == 0 ? 'checked' : ''}} value="0">
                                            Khóa
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <!-- /.form group -->
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>

            </div>
        </form>
        <!-- /.row -->

    </section>

@endsection

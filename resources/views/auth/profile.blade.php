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
                                <label>Họ tên nhân viên:</label>
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
                                    <input disabled type="text" class="form-control" name="phone"
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
                                    <input disabled type="email" class="form-control" name="email"
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
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col (left) -->
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Chức vụ:</label>
                                <select disabled name="role" id="role" class="form-control">
                                    <option value="">--- Mặc định là nhân viên</option>

                                    @foreach(config('data.role') as $key=> $item)
                                        <option value="{{$key}}"
                                            {{!empty($row['role']) && $row['role'] == $key ? 'selected': ''}}
                                            {{!empty(old('role')) && old('role') == $key ? 'selected': ''}}
                                        >{{$item}}</option>
                                    @endforeach
                                </select>

                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->
                            <!-- Date -->
                            <div class="form-group">
                                <label>Tài khoản:</label>

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input disabled type="text" value="{{$row['username']?? old('username') ??""}}"
                                           class="form-control pull-right" name="username">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->

                            <!-- Date range -->
                            <div class="form-group">
                                <label>Mật khẩu:</label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="password" name="password" class="form-control pull-right">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->

                            <!-- Date and time range -->
                            <div class="form-group">
                                <label>Nhập lại mật khẩu:</label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input type="password" name="password_confirmation" class="form-control pull-right">
                                </div>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->

                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.col (right) -->
            </div>
        </form>
        <!-- /.row -->

    </section>

@endsection

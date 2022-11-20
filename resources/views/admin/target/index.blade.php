@extends('admin.layout')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box" style="margin-bottom:0px;">
                    <div style="display:flex; justify-content:space-between; padding:15px;">
                        <!-- search form -->
                        <div>
                            <div class="box-tools">
                                <div class="input-group input-group-sm hidden-xs" style="width: 250px;">
                                    <input type="text" name="table_search" class="form-control pull-right"
                                        placeholder="Search">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="action" style="display:flex; justify-content:space-between">
                            <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Tìm
                                kiếm</button>
                            <button type="button" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Thêm
                                mới</button>
                            <button type="button" class="btn btn-info btn-sm"><i class="fa fa-download"></i> Xuất
                                excel</button>
                            <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-upload"></i> Nhập dữ
                                liệu</button>
                            <button type="button" class="btn btn-warning btn-sm"><i class="fa fa-navicon"></i> Tùy chọn
                            </button>
                            <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-gears"></i> Quản
                                lý</button>
                            <button type="button" class="btn btn-info btn-sm"><i class="fa fa-bar-chart"></i> Báo
                                cáo</button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Công việc
                        </h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-sm" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-sm" data-widget="remove" data-toggle="tooltip"
                                title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <!-- /.box-header -->
                    <div class="box-body no-padding">

                        <table class="table">
                            <tbody>
                                <tr>
                                    <th style="width: 50px">#</th>
                                    <th>Dự án</th>
                                    <th>Mục tiêu</th>
                                    <th>Trạng thái</th>
                                    <th>Nội dung chi tiết</th>
                                    <th>Onwer</th>
                                    <th></th>
                                </tr>

                                <tr>
                                    <td>
                                    </td>
                                    <td>Xây dựng cửa hàng mới</td>
                                    <td>Mua 100 bao xi măng</td>
                                    <td><span class="badge bg-yellow">yêu cầu</span></td>
                                    <td>Xây cầu</td>
                                    <td>admin</td>
                                    <td>
                                        <div style="display:flex; width:50px;">
                                            <a href="" style="margin-right: 5px;"><i class="fa fa-eye"></i></a>
                                            <a href="" style="margin-right: 5px;"><i
                                                    class="fa  fa-pencil-square"></i></a>
                                            <a href=""><i class="fa  fa-times-circle"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td>Xây dựng cửa hàng mới</td>
                                    <td>Mua 2 xe cái</td>
                                    <td><span class="badge bg-light-blue">đã duyệt</span></td>
                                    <td>Xây cầu</td>
                                    <td>admin</td>
                                    <td>
                                        <div style="display:flex; width:50px;">
                                            <a href="" style="margin-right: 5px;"><i class="fa fa-eye"></i></a>
                                            <a href="" style="margin-right: 5px;"><i
                                                    class="fa  fa-pencil-square"></i></a>
                                            <a href=""><i class="fa  fa-times-circle"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td>Xây dựng cửa hàng mới</td>
                                    <td>Mua 2 xe gạch</td>
                                    <td><span class="badge bg-green">hoàn thành</span></td>
                                    <td>Xây cầu</td>
                                    <td>admin</td>
                                    <td>
                                        <div style="display:flex; width:50px;">
                                            <a href="" style="margin-right: 5px;"><i class="fa fa-eye"></i></a>
                                            <a href="" style="margin-right: 5px;"><i
                                                    class="fa  fa-pencil-square"></i></a>
                                            <a href=""><i class="fa  fa-times-circle"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td>Xây dựng cửa hàng mới</td>
                                    <td>Mua 12 xe gạch</td>
                                    <td><span class="badge bg-red">đã hủy</span></td>
                                    <td>Xây cầu</td>
                                    <td>admin</td>
                                    <td>
                                        <div style="display:flex; width:50px;">
                                            <a href="" style="margin-right: 5px;"><i class="fa fa-eye"></i></a>
                                            <a href="" style="margin-right: 5px;"><i
                                                    class="fa  fa-pencil-square"></i></a>
                                            <a href=""><i class="fa  fa-times-circle"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="display:flex; justify-content:space-between; padding:15px;">
                            <h6 class="box-title">7 kết quả trong 1 trang</h3>

                                <div class="box-tools">
                                    <ul class="pagination pagination-sm no-margin pull-right">
                                        <li><a href="#">«</a></li>
                                        <li><a href="#">1</a></li>
                                        <li><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">»</a></li>
                                    </ul>
                                </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col-->
        </div>
        <!-- ./row -->
    </section>
@endsection

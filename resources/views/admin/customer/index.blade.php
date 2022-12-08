@extends('admin.layout')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box" style="margin-bottom:0px;">
                    <div style="display:flex; justify-content:space-between; padding:15px;">
                        <!-- search form -->
                        <div>
                            <form id="form-search">
                                <div class="box-tools">
                                    <div class="input-group input-group-sm hidden-xs" style="width: 250px;">
                                        <input type="text" name="str" value="{{$_GET['str'] ?? ''}}" class="form-control pull-right"
                                               placeholder="Search">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="action" style="display:flex; justify-content:space-between">
                            <button type="button" onclick="document.getElementById('form-search').submit()" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Tìm
                                kiếm
                            </button>
                            <a href="{{route('customer.create')}}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Thêm
                                mới
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Danh sách nhân viên
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
                            <thead>
                            <tr>
                                <th style="width: 50px">#</th>
                                <th class="text-center">Tên Khách hàng</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Số điện thoại</th>
                                <th class="text-center">Giới tính</th>
                                <th class="text-center">Địa chỉ</th>

                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($rows)&& $rows->count() > 0)
                                @foreach($rows as $key=> $item)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td class="text-center">{{$item->name}}</td>

                                        <td class="text-center">{{$item->email}}</td>
                                        <td class="text-center">{{$item->phone}}</td>
                                        <td class="text-center">{{empty($item->gender) ? "Nam" :' Nữ'}}</td>
                                        <td class="text-center">{{$item->address}}</td>
  <td>
                                            <div style="display:flex; width:50px;">
                                                <a href="{{route('customer.edit', ['customer'=>$item])}}" style="margin-right: 5px;"><i
                                                        class="fa  fa-pencil-square"></i></a>
                                                <form action="{{route('customer.destroy', ['customer'=>$item])}}">
                                                    <a class="btn-delete-record"><i class="fa  fa-times-circle"></i></a>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center">
                                        Không tồn tại bản ghi nào
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                            <tfoot>
                            @if(!empty($rows)&& $rows->count() > 0)
                                <tr>
                                    <td colspan="8">
                                        {{$rows->links()}}
                                    </td>
                                </tr>
                            @endif
                            </tfoot>
                        </table>
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

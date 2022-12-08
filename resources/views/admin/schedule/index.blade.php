@extends('admin.layout')
@section('content')
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Lịch làm việc của bạn
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
                                <th class="text-center">Dự án</th>
                                <th class="text-center">Tên công việc</th>
                                <th class="text-center">Ngày bắt đầu</th>
                                <th class="text-center">Ngày kết thúc</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($rows)&& $rows->count() > 0)
                                @foreach($rows as $key=> $item)
                                    <tr>
                                        <td>{{$key + 1}}</td>

                                        <td class="text-center">{{$item->project->name}}</td>

                                        <td class="text-center">{{$item->name}}</td>
                                        <td class="text-center">{{$item->intend_time_start}}</td>
                                        <td class="text-center">{{$item->intend_time_end}}</td>

                                        <td>
                                            <div style="display:flex; width:50px;">
                                                <a href="{{route('task.show', ['task'=>$item])}}"
                                                   class="btn btn-xs btn-primary"><i
                                                        class="fa fa-external-link"></i> Chi tiết</a>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center">
                                        Không tồn tại bản ghi nào
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                            <tfoot>
                            @if(!empty($rows)&& $rows->count() > 0)
                                <tr>
                                    <td colspan="9">
                                        {!! $rows->links() !!}
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

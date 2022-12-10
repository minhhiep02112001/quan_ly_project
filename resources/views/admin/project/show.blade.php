@extends('admin.layout')

@section('content')
    <section class="content">
        @php $status = config('data.project_status')[$row->status] ?? []; @endphp

            <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">{{$title}} <span class="badge {{$status['class'] ?? ''}}">
                                            {{$status['text'] ?? ''}}</span></h3>
                <div class="box-tools pull-right">
                    @if(\Gate::allows('role', ['role' => ['admin','leader']]) && $row->status < 2)

                        @if($row->status == 0 && $row->status != 4)
                            <form style="display: inline-block;" method="post"
                                  action="{{route('project.update', ['project' => $row])}}">
                                @method("PUT")
                                @csrf
                                <input type="hidden" name="customer_id" value="{{$row->customer_id}}">
                                <input type="hidden" name="manager_id" value="{{$row->manager_id}}">
                                <input type="hidden" name="name" value="{{$row->name}}">
                                <input type="hidden" name="status" value="1">
                                <button type="submit" class="btn btn-sm btn-primary">Bắt đầu</button>
                            </form>
                        @endif

                        @if($row->status < 2 && $row->status != 4)
                            <form style="display: inline-block;" method="post"
                                  action="{{route('project.update', ['project' => $row])}}">
                                @method("PUT")
                                @csrf
                                <input type="hidden" name="status" value="2">
                                <input type="hidden" name="customer_id" value="{{$row->customer_id}}">
                                <input type="hidden" name="manager_id" value="{{$row->manager_id}}">
                                <input type="hidden" name="name" value="{{$row->name}}">
                                <button type="submit" class="btn btn-sm btn-success">Hoàn thành</button>
                            </form>
                        @endif



                        @if($row->status < 2)
                            <form style="display: inline-block;" method="post"
                                  action="{{route('project.update', ['project' => $row])}}">
                                @method("PUT")
                                @csrf
                                <input type="hidden" name="customer_id" value="{{$row->customer_id}}">
                                <input type="hidden" name="manager_id" value="{{$row->manager_id}}">
                                <input type="hidden" name="name" value="{{$row->name}}">
                                <input type="hidden" name="status" value="3">
                                <button type="submit" class="btn btn-sm btn-danger">Hủy dự án</button>
                            </form>
                        @endif

                        @if($row->status < 2)
                            <a href="{{route('task.create', ['project_id' => $row->id])}}" class="btn btn-sm btn-success">Thêm công việc </a>
                        @endif

                    @endif
                </div>
            </div>

        </div>
        <!-- /.box -->

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Chi tiết công việc</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title=""
                            data-original-title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title=""
                            data-original-title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body no-padding">

                <table class="table">
                    <thead>
                    <tr>
                        <th style="width: 50px">#</th>
                        <th class="text-center">Công việc</th>
                        <th class="text-center">Nhân viên thực hiện</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Ngày bắt đầu</th>
                        <th class="text-center">Ngày kết thúc</th>
                        <th class="text-center">Ngày bắt thực tế</th>
                        <th class="text-center">Ngày kết thúc thực tế</th>
                        <th class="text-center">Tỷ lệ hoàn thành</th>
                        <th class="text-center">Chi tiết</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($tasks))
                        @foreach($tasks as $key=> $item)
                            @php $status = config('data.task_status')[$item->status] ?? []; @endphp
                            <tr>
                                <td>{{$key}}</td>
                                <td class="text-center">{{$item->name}}</td>
                                <td class="text-center">{{$item->employee_id}}</td>
                                <td class="text-center"><span class="badge {{$status['class'] ?? ''}}">
                                            {{$status['text'] ?? ''}}</span></td>
                                <td class="text-center">{{$item->intend_time_start}}</td>
                                <td class="text-center">{{$item->intend_time_end}}</td>
                                <td class="text-center">{{$item->start_date}}</td>
                                <td class="text-center">{{$item->end_date}}</td>
                                <td class="text-center">{{$item->progress}}%</td>
                                <td class="text-center">{{$item->note}}</td>
                                <td>
                                    <div style="display:flex; width:100px;">
                                        <a class="btn btn-warning btn-xs"
                                           href="{{route('task.show', ['task' => $item])}}">Báo cáo</a>
                                        @if(\Gate::allows('role', ['role' => ['admin','leader']]))
                                        <form style="display: inline-block; margin-left: 5px;" method="post"
                                              action="{{route('task.destroy', ['task' => $item])}}">
                                            @method("DELETE")
                                            @csrf
                                            <button type="submit" class="btn btn-xs btn-danger">Xóa</button>
                                        </form>
                                        @endif
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
                            <td colspan="11">
                                {!! $rows->links() !!}
                            </td>
                        </tr>
                    @endif
                    </tfoot>
                </table>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                Tiến độ dự án : <span class="badge badge-success">{{$ratio ?? 0}}%</span>
            </div>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->

        <!-- /.row -->

    </section>

@endsection

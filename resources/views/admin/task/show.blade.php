@extends('admin.layout')

@section('content')
    @php
        $status_project = $row->project->status;
    @endphp

    <section class="content">

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Chi tiết công việc: <u>{{$row['name']}}</u></h3> &nbsp;
                @if($status_project == 2 || $status_project == 3)
                    <span class="badge badge-success"> Dự Án Hoàn Thành</span>
                @endif
                <a href="{{url()->previous()}}" style="margin-left: 10px;" class="btn btn-sm btn-success">Quay lại</a>
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
            </div>
        </div>
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Báo cáo công việc theo ngày</h3>

                @if(\Gate::allows('role', ['role' => ['admin','leader']]))
                    <form style="display: inline-block;" method="post" action="/task/{{$row->id}}">
                        @method("PUT")
                        @csrf
                        <input type="hidden" name="status" value="1">
                        <input type="hidden" name="name" value="{{$row->name}}">
                        <input type="hidden" name="project_id" value="{{$row->project_id}}">
                        <input type="hidden" name="employee_id" value="{{$row->employee_id}}">
                        <button type="submit"
                                {{$row->status ? 'disabled' : ''}}
                                class="btn btn-xs btn-success"><i
                                class="fa fa-check-square"></i> Hoàn thành
                        </button>
                    </form>
                @endif

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
                        <th class="text-center">Tỷ lệ hoàn thành</th>
                        <th class="text-center">Chi tiết</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($progress))
                        @php $status = config('data.progress_status')@endphp

                        @foreach($progress as $key=> $item)

                            <tr>
                                <td>{{$key +1}}</td>
                                <td class="text-center">{{$item->task->name}}</td>
                                <td class="text-center">{{$item->employee->name}}</td>
                                <td class="text-center">
                                    <span
                                        class="badge {{!empty($status[$item->status]) ? $status[$item->status]['class'] :''}}">
                                            {{!empty($status[$item->status]) ? $status[$item->status]['text'] :''}}</span>
                                </td>
                                <td class="text-center">{{$item->time_start}}</td>
                                <td class="text-center">{{$item->time_end}}</td>
                                <td class="text-center">
                                     <span
                                         class="badge {{!empty($status[$item->status]) ? $status[$item->status]['class'] :''}}">
                                             {{$item->progress}}%
                                    </span>
                                </td>
                                <td class="text-center">{{$item->note}}</td>
                                <td>
                                <td>
                                    <div>

                                        <a href="Javascript:void(0)" class="view-progress btn btn-xs btn-primary"
                                           data-id="{{$item->id}}"
                                           data-title="{{"Chi tiết công việc ngày {$item->time_start} - {$item->time_end}"}}"
                                           style="margin-right: 5px;"><i
                                                class="fa fa-external-link"></i> Chi tiết</a>

                                        @if($status_project != 2 && $status_project != 3 && $item->status != 2)
                                            <a href="Javascript:void(0)" class="edit-progress btn btn-xs btn-warning"
                                               data-id="{{$item->id}}"
                                               data-title="{{"Báo cáo công việc ngày {$item->time_start} - {$item->time_end}"}}"
                                               style="margin-right: 5px;"><i class="fa  fa-pencil-square"></i> Báo cáo</a>

                                        @endif


                                        @if(\Gate::allows('role', ['role' => ['admin','leader']]) && $item->status < 2)
                                            <form style="display: inline-block;" method="post"
                                                  action="/progress/{{$item->id}}">
                                                @method("PUT")
                                                @csrf
                                                <input type="hidden" name="status" value="2">
                                                <button type="submit" class="btn btn-xs btn-success"><i
                                                        class="fa fa-check-square"></i> Duyệt
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
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
                Tiến độ công việc : <span class="badge badge-success">{{$ratio ?? 0}}%</span>
            </div>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->

        <!-- /.row -->
    </section>
    <div class="modal fade" id="edit_progress" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
         aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title "></h4>
                </div>
                <div class="modal-body">
                    <form id="form-progress" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <!-- /.col (left) -->
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-body">
                                        <input type="hidden" name="id" value="">
                                        <!-- /.form group -->
                                        <!-- Date -->
                                        <div class="form-group">
                                            <label>Hình ảnh hoặc file:</label>
                                            <div class="parent-upload" data-field="contract_files">
                                                <input type="file"
                                                       id="upload-files"
                                                       class="filepond upload-file"
                                                       name="files"
                                                       multiple
                                                       data-field="contract_files">
                                                <input id="contract_files" type="hidden" name="contract_files"
                                                       value="{{$row->contract_files ?? ''}}"
                                                       required>
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <!-- /.form group -->

                                        <!-- phone mask -->
                                        <div class="form-group">
                                            <label>Ghi chú:</label>

                                            <textarea class="form-control" name="note" rows="5"></textarea>
                                            <!-- /.input group -->
                                        </div>
                                        <!-- /.form group -->
                                        <!-- phone mask -->
                                        <div class="form-group">
                                            <label>Tiến độ (%):</label>
                                            <select name="progress" class="form-control">
                                                <option value="0">0</option>
                                                <option value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="30">30</option>
                                                <option value="40">40</option>
                                                <option value="50">50</option>
                                                <option value="60">60</option>
                                                <option value="70">70</option>
                                                <option value="80">80</option>
                                                <option value="90">90</option>
                                                <option value="100">100</option>
                                            </select>
                                        </div>
                                        <!-- /.form group -->
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                            <!-- /.col (right) -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-form-progress">Save changes</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="view-progress" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
         aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title "></h4>
                </div>
                <div class="modal-body">
                    <table class="table table-hover">

                        <tbody class="content-table">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('style_css')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
@endsection

@section('javascripts')
    <script>
        var URL_UPDATE_PROGRESS = window.APP_URL + '/progress';
        FileUpload.init($("#edit_progress"));
        $(document).ready(function () {
            $(document).on('click', '.edit-progress', function () {
                let progress_id = $(this).data('id');
                $("#edit_progress").find('input[name="id"]').val(progress_id);
                let title = $(this).data('title');
                $("#edit_progress").find('.modal-title').html(title);
                var fieldName = $("#edit_progress").find('.parent-upload').attr('data-field');
                $("#edit_progress").find('input[name="' + fieldName + '"]').val('');
                FileUpload.init($("#edit_progress"));
                $('#edit_progress').modal('show');
                // $('#myModal').modal('hide');
            })

            $(document).on('click', '#save-form-progress', function (e) {
                e.preventDefault()
                let param = $('form#form-progress').serialize();
                let id = $('form#form-progress').find('input[name="id"]').val();
                param = param + `&status=1`;
                $.ajax({
                    url: URL_UPDATE_PROGRESS + '/' + id,
                    type: "PUT",
                    data: param,
                    dataType: 'json',
                    cache: false,
                    success: function (response) {
                        $('#edit_progress').modal('hide');
                        location.href = document.URL;
                    },
                    error: function () {

                    },
                });
                return false;
            })
        })


        $(document).ready(function () {
            $(document).on('click', '.view-progress', function () {
                let progress_id = $(this).data('id');
                let title = $(this).data('title');
                $("#view-progress").find('.modal-title').html(title);
                showProgress(progress_id);
                $('#view-progress').modal('show');
                // $('#myModal').modal('hide');
            })

            function showProgress(id) {
                $.ajax({
                    url: URL_UPDATE_PROGRESS + '/' + id,
                    type: "GET",
                    dataType: 'json',
                    cache: false,
                    success: function (response) {
                        let html = `<tr><th width="10%">Nhân viên: </th> <td class="text-left">${response.employee_name}</td> </tr>`;
                        html += `<tr><th width="10%">Note: </th> <td class="text-left">${response.note}</td> </tr>`;
                        html += `<tr><th width="10%">Files: </th> <td class="text-left">`;
                        if (response.contract_files) {
                            $.each(response.contract_files, function (i, item) {
                                html += `<a href="${APP_URL}/${item}" target="_blank">File ${i + 1}</a><br>`
                            })
                        }
                        html += `</td> </tr>`;
                        html += `<tr><th width="10%">Tiến độ: </th> <td class="text-left">${response.progress}%</td> </tr>`;
                        html += `<tr><th width="10%">Trạng thái: </th> <td class="text-left">`
                        if (response.status == 0) html += 'Chưa bắt đầu';
                        else if (response.status == 1) html += 'Chờ phê duyệt';
                        else html += 'Hoàn thành';
                        html += `</tr>`;
                        $('#view-progress').find('table .content-table').html(html);
                    },
                    error: function () {
                        $('#view-progress').find('table .content-table').html('');
                    },
                });
            }
        })
    </script>
@endsection






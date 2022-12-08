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
                    <a href="{{route('task.index')}}" class="btn btn-sm btn-danger">Hủy</a>
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
                                <label>Tên dự án:</label>
                                <input type="text" class="form-control" name="name"
                                       value="{{$row['name']?? old('name') ?? ''}}">
                                <!-- /.input group -->
                            </div>

                            <!-- phone mask -->
                            <div class="form-group">
                                <label>Mô tả dự án:</label>
                                <textarea class="form-control" rows="5"
                                          name="note">{!! $row['note'] ?? old('note') ?? '' !!}</textarea>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->


                            <!-- phone mask -->
                            <div class="form-group">
                                <label>Dự toán:</label>
                                <input type="text" class="form-control" name="estimate_cost"
                                       value="{{$row['estimate_cost'] ?? old('estimate_cost') ?? ''}}">
                            </div>
                            <!-- /.form group -->

                            <!-- phone mask -->
                            <div class="form-group">
                                <label>Chi phí:</label>
                                <input type="text" class="form-control" name="cost"
                                       value="{{$row['cost'] ?? old('cost') ?? ''}}">
                            </div>
                            <!-- /.form group -->
                            <!-- phone mask -->
                            <div class="form-group">
                                <label>Trạng thái:</label>
                                <select name="status" id="status" class="select2 form-control">
                                    @foreach(config('data.project_status') as $key=> $item)
                                        <option value="{{$key}}"
                                            {{!empty($row->status) && $row->status == $key ? 'selected': ''}}
                                            {{!empty(old('status')) && old('status') == $key ? 'selected': ''}}
                                        >{{$item['text'] ?? ''}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <!-- /.form group -->
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
                                <label>Khách hàng:</label>
                                <select name="customer_id" id="role" class="select2 form-control">
                                    <option value="">---</option>
                                    @foreach($customers as $key=> $item)
                                        <option value="{{$item->id}}"
                                            {{!empty($row->customer_id) && $row->customer_id == $item->id ? 'selected': ''}}
                                            {{!empty(old('role')) && old('role') == $item->id ? 'selected': ''}}
                                        >{{$item->name}} / {{$item->email}} / {{$item->phone}}</option>
                                    @endforeach
                                </select>

                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->
                            <!-- Date -->
                            <div class="form-group">
                                <label>Hình ảnh hợp đồng:</label>

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

{{--                                <div id="upload-files" data-field="contract_files">--}}
{{--                                    <input type="file"--}}
{{--                                           class="filepond upload-file"--}}
{{--                                           name="files"--}}
{{--                                           multiple--}}
{{--                                           data-allow-image-edit="false"--}}
{{--                                           data-max-file-size="3MB"--}}
{{--                                           data-max-files="3">--}}
{{--                                    <input id="contract_files" type="hidden" name="contract_files" value="{{$row->contract_files ?? ''}}"--}}
{{--                                           required>--}}
{{--                                </div>--}}
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->

                            <!-- Date and time range -->
                            <div class="form-group">
                                <label>Quản lý dự án:</label>
                                <div class="form-group mb-0">
                                    <select name="manager_id" id="role" class="select2 form-control">
                                        <option value="">---</option>
                                        @foreach($managers as $key=> $item)
                                            <option value="{{$item->id}}"
                                                {{!empty($row->manager_id) && $row->manager_id == $item->id ? 'selected': ''}}
                                                {{!empty(old('manager_id')) && old('manager_id') == $item->id ? 'selected': ''}}
                                            >{{$item->name}} - {{$item->role}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- /.form group -->

                            <!-- phone mask -->
                            <div class="form-group">
                                <label>Thời gian dự định bắt đầu bắt đầu:</label>

                                <input type="date" class="form-control" name="intend_time_start"
                                       value="{{$row['intend_time_start'] ?? old('intend_time_start') ?? ''}}">

                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->
                            <!-- phone mask -->
                            <div class="form-group">
                                <label>Thời gian dự định kết thúc dự án:</label>

                                <input type="date" class="form-control" name="intend_time_end"
                                       value="{{$row['intend_time_end'] ?? old('intend_time_end') ?? ''}}">


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


@section('style_css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
@endsection

@section('javascripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
          rel="stylesheet">

    <!-- include FilePond library -->
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

    <!-- include FilePond plugins -->
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>

    <!-- include FilePond jQuery adapter -->
    <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>

{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            $('.select2').select2();--}}
{{--        });--}}

{{--        $(function () {--}}
{{--            // First register any plugins--}}
{{--            $.fn.filepond.registerPlugin(--}}
{{--                FilePondPluginImagePreview--}}
{{--            );--}}
{{--            var self = $('input[type="file"]');--}}

{{--            var files = [];--}}
{{--            var isMultiUpload = (self.attr('multiple')) ? 1 : 0;--}}
{{--            var domUpload = self.closest('#upload-files');--}}
{{--            var fieldName = domUpload.attr('data-field');--}}
{{--            var hiddenField = domUpload.find('input[name="' + fieldName + '"]');--}}

{{--            if (hiddenField) {--}}
{{--                if (isMultiUpload == 1) { /// upload 1 file--}}
{{--                    let input = hiddenField.val();--}}

{{--                    if(input){--}}
{{--                        $.each(val_files, function (K, item) {--}}
{{--                            files.push(--}}
{{--                                {--}}
{{--                                    source: item,--}}
{{--                                    options: {type: 'local'}--}}
{{--                                });--}}
{{--                        });--}}
{{--                    }--}}
{{--                }--}}
{{--            }--}}
{{--            self.filepond({--}}
{{--                files: files,--}}
{{--                //allowMultiple: true,--}}
{{--                //name: 'files',--}}
{{--                maxParallelUploads: 10,--}}
{{--                checkValidity: true,--}}
{{--                forceRevert: true,--}}
{{--                server: {--}}
{{--                    url: '',--}}
{{--                    timeout: 7000,--}}
{{--                    process: {--}}
{{--                        url: window.URL_UPLOAD_FILE,--}}
{{--                        method: 'POST',--}}
{{--                        headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},--}}
{{--                        withCredentials: false,--}}
{{--                        onload: (res) => {--}}
{{--                            files = self.filepond('getFiles');--}}

{{--                            if (!isMultiUpload) {--}}
{{--                                domUpload.find('input[name="' + fieldName + '"]').val(res);--}}
{{--                            } else {--}}
{{--                                let arr = files.map(function (item, i) {--}}
{{--                                    return item.serverId--}}
{{--                                })--}}
{{--                                arr = arr.filter(n => {--}}
{{--                                    return n && typeof n == "string";--}}
{{--                                });--}}
{{--                                arr.push(res);--}}
{{--                                let value = JSON.stringify(arr);--}}
{{--                                domUpload.find('input[name="' + fieldName + '"]').val(value);--}}
{{--                            }--}}

{{--                            //$("body").html('<input type="hidden" name="' + fieldName + '" value="' + res.path +'">');--}}
{{--                            return res;--}}

{{--                        },--}}
{{--                        onerror: (response) => {--}}
{{--                            alert('Lỗi Upload: ' + response);--}}
{{--                        }//,--}}

{{--                    },--}}
{{--                    revert: null,--}}
{{--                    restore: null,--}}
{{--                    load: window.APP_URL + '/',--}}
{{--                    fetch: null--}}
{{--                },--}}
{{--                onremovefile: (error, file) => {--}}
{{--                    if (isMultiUpload) {--}}
{{--                        var files = self.filepond('getFiles');--}}
{{--                        let arr = [];--}}
{{--                        $.each(files, (idx,item) => arr.push(item.serverId));--}}
{{--                        domUpload.find('input[name="' + fieldName + '"]').val(JSON.stringify(arr));--}}
{{--                    } else {--}}
{{--                        domUpload.find('input[name="' + fieldName + '"]').val('');--}}
{{--                    }--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--        // Turn input element into a pond--}}

{{--    </script>--}}

@endsection

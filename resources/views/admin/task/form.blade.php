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
                    <a href="{{url()->previous()}}" class="btn btn-sm btn-danger">Hủy</a>
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
                <div class="col-md-8">

                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Dự án:</label>
                                <div class="form-group mb-0">
                                    <select name="project_id" id="role" class="select2 form-control">
                                        <option value="">---</option>
                                        @foreach($project as $key=> $item)
                                            <option value="{{$item->id}}"
                                                {{!empty($row->project_id) && $row->project_id == $item->id ? 'selected': ''}}
                                                {{!empty(old('project_id')) && old('project_id') == $item->id ? 'selected': ''}}
                                            >{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tên task:</label>
                                <input type="text" class="form-control" name="name"
                                       value="{{$row['name']?? old('name') ?? ''}}">
                                <!-- /.input group -->
                            </div>

                            <!-- phone mask -->
                            <div class="form-group">
                                <label>Mô tả:</label>
                                <textarea class="form-control" rows="5"
                                          name="note">{!! $row['note'] ?? old('note') ?? '' !!}</textarea>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->
                            <!-- phone mask -->
                            <div class="form-group">
                                <label>Trạng thái:</label>
                                <select name="status" id="status" class="select2 form-control">
                                    @foreach(config('data.task_status') as $key=> $item)
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
                <div class="col-md-4">

                    <div class="box box-danger">
                        <div class="box-body">
                            <!-- phone mask -->
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Chọn nhân viên làm:</label>
                                    <div class="form-group mb-0">
                                        <select name="employee_id" id="role" class="select2 form-control">
                                            <option value="">---</option>
                                            @foreach($managers as $key=> $item)
                                                <option value="{{$item->id}}"
                                                    {{!empty($row->employee_id) && $row->employee_id == $item->id ? 'selected': ''}}
                                                    {{!empty(old('employee_id')) && old('employee_id') == $item->id ? 'selected': ''}}
                                                >{{$item->name}} - {{$item->role}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.form group -->

                            <!-- phone mask -->

                            <div class="form-group">
                                <label>Thời gian dự định bắt đầu:</label>

                                <input type="date" required class="form-control" name="intend_time_start" {{!empty($row['intend_time_start']) ? 'disabled' : ''}}
                                       value="{{$row['intend_time_start'] ?? old('intend_time_start') ?? ''}}">

                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->
                            <!-- phone mask -->
                            <div class="form-group">
                                <label>Thời gian dự định kết thúc dự án:</label>

                                <input type="date" required class="form-control" name="intend_time_end"  {{!empty($row['intend_time_end']) ? 'disabled' : ''}}
                                       value="{{$row['intend_time_end'] ?? old('intend_time_end') ?? ''}}">


                            </div>
                            <!-- /.form group -->
                            <div class="form-group">
                                <label>Chi phí:</label>
                                <input type="text" class="form-control" name="cost"
                                       value="{{$row['cost'] ?? old('cost') ?? ''}}">
                            </div>
                        </div>
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

    <script>
        $(function () {
            // First register any plugins
            $.fn.filepond.registerPlugin(
                FilePondPluginImagePreview
            );
            var self = $('input.upload-file');
            var fieldName = self.attr('data-field');
            var files = [];
            var isMultiUpload = (self.attr('multiple')) ? 1 : 0;
            var domUpload = self.parent();
            var hiddenField = domUpload.find('input[name="' + fieldName + '"]');

            if (hiddenField) {
                if (isMultiUpload == 1) { /// upload 1 file
                    let input = hiddenField.val();
                    if(input){
                        $.each(val_files, function (K, item) {
                            files.push(
                                {
                                    source: item,
                                    options: {type: 'local'}
                                });
                        });
                    }
                }
            }
            self.filepond({
                files: files,
                //allowMultiple: true,
                //name: 'files',
                maxParallelUploads: 10,
                checkValidity: true,
                forceRevert: true,
                server: {
                    url: '',
                    timeout: 7000,
                    process: {
                        url: window.URL_UPLOAD_FILE,
                        method: 'POST',
                        headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                        withCredentials: false,
                        onload: (res) => {
                            files = self.filepond('getFiles');

                            if (!isMultiUpload) {
                                domUpload.find('input[name="' + fieldName + '"]').val(res);
                            } else {
                                let arr = files.map(function (item, i) {
                                    return item.serverId
                                })
                                arr = arr.filter(n => {
                                    return n && typeof n == "string";
                                });
                                arr.push(res);
                                let value = JSON.stringify(arr);
                                domUpload.find('input[name="' + fieldName + '"]').val(value);

                            }

                            //$("body").html('<input type="hidden" name="' + fieldName + '" value="' + res.path +'">');
                            return res;

                        },
                        onerror: (response) => {
                            alert('Lỗi Upload: ' + response);
                        }//,

                    },
                    revert: null,
                    restore: null,
                    load: window.APP_URL + '/',
                    fetch: null
                },
                onremovefile: (error, file) => {
                    if (isMultiUpload) {
                        var files = self.filepond('getFiles');
                        let arr = [];
                        $.each(files, (idx,item) => arr.push(item.serverId));
                        domUpload.find('input[name="' + fieldName + '"]').val(JSON.stringify(arr));
                    } else {
                        domUpload.find('input[name="' + fieldName + '"]').val('');
                    }
                }
            });
        });
        // Turn input element into a pond

    </script>

@endsection

@section('style_css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endsection

@section('javascripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
@endsection

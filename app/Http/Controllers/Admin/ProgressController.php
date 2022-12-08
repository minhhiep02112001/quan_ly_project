<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Listeners\ListenerCreateTask;
use App\Models\Progress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProgressController extends Controller
{
    protected $onlyRequest = ['employee_id', 'task_id', 'time_start', 'time_end', 'progress', 'note', 'contract_files', 'status'];

    function update(Request $request, $id)
    {
        $data = array_filter($request->only($this->onlyRequest));

        try {
            DB::beginTransaction();
            $progress = Progress::find($id);
            $progress->update($data);
            DB::commit();
            if ($request->status == 2) {
                (new ListenerCreateTask())->updateProgressTask($progress->task_id);
            }
            return response()->json(['status' => 'success', 'message' => 'Thành công']);
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => 'Lỗi !!!']);
        }
    }

    function show($id)
    {
        $progress = Progress::find($id);
        $data = $progress->only($this->onlyRequest);
        $data['contract_files'] = json_decode($data['contract_files'], true);
        $data['employee_name'] = $progress->employee->name;
        return response()->json($data);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Listeners\ListenerCreateTask;
use App\Models\Customer;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    protected $requestInput = ['name', 'project_id', 'employee_id', 'intend_time_start', 'intend_time_end', 'note', 'cost', 'status'];

    public function index(Request $request)
    {
        $rows = Task::where(function ($query){
            if (Auth::user()->role == 'employee'){
                return $query->where('employee_id' , Auth::id());
            }
        })->paginate(10);
        $data = [
            'rows' => $rows
        ];
        return view('admin.task.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $project = Project::where(function ($query){
            if (Auth::user()->role != 'admin'){
                return $query->where('manager_id', Auth::id());
            }
        })->get();

        $managers = User::select(['id', 'name', 'email', 'phone', 'role'])->get();
        $data = [
            'action' => route('task.store'),
            'method' => "POST",
            'title' => "Thêm task dự án",
            'project' => $project,
            'managers' => $managers,
        ];
        return view('admin.task.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:table_task,name',
            'project_id' => 'required',
            'employee_id' => 'required',
        ]);
        $data = $request->only($this->requestInput);

        try {
            DB::beginTransaction();
            $task = Task::insertGetId($data);
            DB::commit();
            (new ListenerCreateTask())->renderProgress(['task_id' => $task]);
            return redirect()->route('task.index')->with('notification_success', 'Thêm task công việc thành công');
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('notification_error', 'Lỗi !!! Thêm task công việc không thành công');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $progress = $task->progress()->get();
        $count_progress = $task->progress()->count();
        $progress_success = $task->progress()->where('status' , 2)->get();
        $task_progress = $progress_success->sum('progress');
        if (!empty($task_progress)){
            $ratio = (( $task_progress/$count_progress ) / 100) * 100;
        }else{
            $ratio =0;
        }

        $data = [
            'row' => $task,
            'progress' => $progress,
            'ratio' => $ratio
        ];

        return view('admin.task.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        if (!Gate::allows('role', ['role' => ['admin', 'leader']])) {
            return abort(403);
        }

        if (Auth::user()->role != 'admin') {
            if (Auth::user()->role == 'leader'){
                if (Auth::id() != $task->project->manager_id){
                    return abort(403);
                }
            }else{
                if (Auth::id() != $task->employee_id){
                    return abort(403);
                }
            }
        }

        $project = Project::where(function ($query){
             if (Auth::user()->role != 'admin'){
                 return $query->where('manager_id', Auth::id());
             }
        })->get();
        $managers = User::select(['id', 'name', 'email', 'phone', 'role'])->get();
        $data = [
            'action' => route('task.update', ['task'=> $task]),
            'method' => "PUT",
            'title' => "Sửa task dự án",
            'project' => $project,
            'managers' => $managers,
            'row' => $task
        ];
        return view('admin.task.form', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $data = array_filter($request->only($this->requestInput));

        if (!Gate::allows('role', ['role' => ['admin', 'leader']])) {
            return abort(403);
        }

        if (Auth::user()->role != 'admin') {
            if (Auth::user()->role == 'leader'){
                if (Auth::id() != $task->project->manager_id){
                    return abort(403);
                }
            }
        }


        $validator = Validator::make($data, [
            'name' => 'required|unique:table_task,name,'.$task->id,
            'project_id' => 'required',
            'employee_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            if (!empty($data['status'])){
                $data['progress'] = 100;
                $data['end_date'] = now()->format('Y-m-d');
            }

            $task->update($data);
            if (!empty($data['status'])){
                $task->progress()->update([
                    'status' => 2,
                    'progress' => '100'
                ]);

            }
            DB::commit();
            return redirect()->route('task.index')->with('notification_success', 'Sửa task công việc thành công');
        } catch (\Exception $ex) {
            dd($ex);
            DB::rollback();
            return back()->with('notification_error', 'Lỗi !!! Sửa task công việc không thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        if (!Gate::allows('role', ['role' => ['admin', 'leader']])) {
            return abort(403);
        }

        if (Auth::user()->role != 'admin') {
            if (Auth::user()->role == 'leader'){
                if (Auth::id() != $task->project->manager_id){
                    return abort(403);
                }
            }else{
                if (Auth::id() != $task->employee_id){
                    return abort(403);
                }
            }
        }

        if ($task->delete()) {
            return back()->with('notification_success', 'Xóa task công việc thành công');
        }
        return back()->with('notification_error', 'Lỗi !!! Xóa task công việc không thành công');
    }
}

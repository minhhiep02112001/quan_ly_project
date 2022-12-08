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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    protected $requestInput = ['name', 'customer_id', 'manager_id', 'intend_time_start', 'intend_time_end', 'start_date', 'end_date', 'note', 'estimate_cost', 'cost', 'contract_files', 'status'];

    public function index(Request $request)
    {
        $project_id = [];
        if (!Gate::allows('role', ['role' => ['admin']])) {
            $project_id = Task::where('employee_id', Auth::id())->pluck('project_id')->toArray();
            if (Auth::user()->role == 'leader') {
                $ids = Project::where('manager_id', Auth::id())->pluck('id')->toArray();
                $project_id = array_merge($project_id, $ids);
                $project_id = array_unique($project_id);
            }
        }
        $data = [];
        if ($request->has('str') && !empty($request->str)) {
            $data[] = ['name', 'like', "%{$request->str}%"];
        }

        $rows = Project::where(function ($query) use ($data) {
            if (!empty($data)) {
                array_map(function ($item) use ($query) {
                    return $query->orWhere(...$item);
                }, $data);
            }
        })->where(function ($query) use ($project_id) {
            if (!empty($project_id)) {
                return $query->whereIn('id', $project_id);
            }
        })->paginate(10);

        $data = [
            'rows' => $rows->appends($request->all())
        ];
        return view('admin.project.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('role', ['role' => ['admin', 'leader']])) {
            return abort(403);
        }
        $managers = User::where('role', 'admin')->orWhere('role', 'leader')->select(['id', 'name', 'email', 'phone', 'role'])->get();
        $customers = Customer::select(['id', 'name', 'email', 'phone'])->get();
        $data = [
            'action' => route('project.store'),
            'method' => "POST",
            'title' => "Thêm dự án",
            'customers' => $customers,
            'managers' => $managers,
        ];
        return view('admin.project.form', $data);
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
            'name' => 'required|unique:table_project,name',
            'customer_id' => 'required',
            'manager_id' => 'required',
        ]);
        $data = $request->only($this->requestInput);

        try {
            DB::beginTransaction();
            Project::insert($data);
            DB::commit();
            return redirect()->route('project.index')->with('notification_success', 'Thêm nhân viên thành công');
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('notification_error', 'Lỗi !!! Thêm nhân viên không thành công');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $tasks = $project->tasks()->where(function ($query) {
            if (Auth::user()->role == 'employee'){
                return $query->where('employee_id' , Auth::id());
            }
        })->get();

        $count_progress = $tasks->count();
        $task_progress = $tasks->sum('progress');
        if (!empty($task_progress)){
            $ratio = (( $task_progress/$count_progress ) / 100) * 100;
        }else{
            $ratio =0;
        }
        $data = [
            'row' => $project,
            'tasks' => $tasks,
            'title' => "Chi tiết dự án: {$project->name}",
            'ratio' => $ratio
        ];
        return view('admin.project.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        if (!Gate::allows('role', ['role' => ['admin', 'leader']])) {
            return abort(403);
        }


        if (Auth::user()->role != 'admin') {
            if (Auth::id() != $project->manager_id){
                return abort(403);
            }
        }


        $managers = User::where('role', 'admin')->orWhere('role', 'leader')->select(['id', 'name', 'email', 'phone', 'role'])->get();
        $customers = Customer::select(['id', 'name', 'email', 'phone'])->get();
        $data = [
            'action' => route('project.update', ['project' => $project]),
            'method' => "PUT",
            'row' => $project,
            'customers' => $customers,
            'managers' => $managers,
            'title' => "Sửa dự án {$project->name}",
        ];
        return view('admin.project.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        if (!Gate::allows('role', ['role' => ['admin', 'leader']])) {
            return abort(403);
        }


        if (Auth::user()->role != 'admin') {
            if (Auth::id() != $project->manager_id){
                return abort(403);
            }
        }
        $data = array_filter($request->only($this->requestInput));
        $validator = Validator::make($data, [
            'name' => 'required|unique:table_project,name,' . $project->id,
            'customer_id' => 'required',
            'manager_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            $project->update($data);
            DB::commit();
            return redirect()->route('project.index')->with('notification_success', 'Sửa dự án thành công');
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('notification_error', 'Lỗi !!! Sửa dự án không thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if (!Gate::allows('role', ['role' => ['admin', 'leader']])) {
            return abort(403);
        }

        if (Auth::user()->role != 'admin') {
            if (Auth::id() != $project->manager_id){
                return abort(403);
            }
        }

        if ($project->delete()) {
            return back()->with('notification_success', 'Xóa dự án thành công');
        }
        return back()->with('notification_error', 'Lỗi !!! Xóa dự án không thành công');
    }
}

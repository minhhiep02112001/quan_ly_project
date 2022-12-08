<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $requestInput = ['name', 'username', 'password', 'gender', 'is_status', 'role', 'address', 'phone', 'email'];

    public function __construct()
    {


    }

    public function index(Request $request)
    {
        if (!Gate::allows('role', ['role' => ['admin']])){
            return abort(403);
        }
        $data= [];
        if ($request->has('str') && !empty($request->str)) {
            $data[] = ['username', 'like', "%{$request->str}%"];
            $data[] = ['email', 'like', "%{$request->str}%"];
            $data[] = ['phone', 'like', "%{$request->str}%"];
            $data[] = ['address', 'like', "%{$request->str}%"];
        }
        $rows = User::where(function ($query) use ($data) {
            if (!empty($data)){
                array_map(function ($item) use ($query){
                    return $query->orWhere(...$item);
                },$data);
            }
        })->paginate(10);
        $data = [
            'rows' => $rows->appends($request->all())
        ];
        return view('admin.users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('role', ['role' => ['admin']])){
            return abort(403);
        }
        $data = [
            'action' => route('employee.store'),
            'method' => "POST",
            'title' => "Thêm nhân viên",
        ];
        return view('admin.users.form', $data);
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'username' => 'required|min:5|unique:users,username',
            'password' => 'required|min:6|confirmed',
        ]);
        $data = $request->only($this->requestInput);
        try {
            DB::beginTransaction();
            $data['password'] = Hash::make($data['password']);
            User::insert($data);
            DB::commit();
            return redirect()->route('employee.index')->with('notification_success', 'Thêm nhân viên thành công');
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
    public function show(User $employee)
    {
        if (!Gate::allows('role', ['role' => ['admin']])){
            return abort(403);
        }
        $data = [
            'row' => $employee,
            'action' => route('employee.update', ['employee' => $employee]),
            'method' => "PUT",
            'title' => "Sửa nhân viên {$employee->name}",
        ];
        return view('admin.users.form', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $employee)
    {
        if (!Gate::allows('role', ['role' => ['admin']])){
            return abort(403);
        }
        $data = [
            'action' => route('employee.update', ['employee' => $employee]),
            'method' => "PUT",
            'row' => $employee,
            'title' => "Sửa nhân viên {$employee->name}",
        ];
        return view('admin.users.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $employee)
    {
        $data = array_filter($request->only($this->requestInput));

        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'. $employee->id,
            'phone' => 'required|unique:users,phone,'. $employee->id,
            'username' => 'required|min:5|unique:users,username,'. $employee->id,
            'password' => 'sometimes|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            if (!empty($data['password'])) $data['password'] = Hash::make($data['password']);
            $employee->update($data);
            DB::commit();
            return redirect()->route('employee.index')->with('notification_success', 'Sửa nhân viên thành công');
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('notification_error', 'Lỗi !!! Sửa nhân viên không thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $employee)
    {
        if (!Gate::allows('role', ['role' => ['admin']])){
            return abort(403);
        }
        if ($employee->delete()){
            return back()->with('notification_success', 'Xóa nhân viên thành công');
        }
        return back()->with('notification_error', 'Lỗi !!! Xóa nhân viên không thành công');
    }


}

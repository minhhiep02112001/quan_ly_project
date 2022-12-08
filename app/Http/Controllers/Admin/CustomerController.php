<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    protected $requestInput = ['name', 'username', 'password', 'gender', 'is_status', 'role', 'address', 'phone', 'email'];

    public function index(Request $request)
    {
        if (!Gate::allows('role', ['role' => ['admin']])){
            return abort(403);
        }
        $data =[];
        if ($request->has('str') && !empty($request->str)) {
            $data[] = ['name', 'like', "%{$request->str}%"];
            $data[] = ['email', 'like', "%{$request->str}%"];
            $data[] = ['phone', 'like', "%{$request->str}%"];
            $data[] = ['address', 'like', "%{$request->str}%"];
        }
        $rows = Customer::where(function ($query) use ($data) {
            if (!empty($data)){
                array_map(function ($item) use ($query){
                    return $query->orWhere(...$item);
                },$data);
            }
        })->paginate(10);
        $data = [
            'rows' => $rows->appends($request->all())
        ];
        return view('admin.customer.index', $data);
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
            'action' => route('customer.store'),
            'method' => "POST",
            'title' => "Thêm nhân viên",
        ];
        return view('admin.customer.form', $data);
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
            'email' => 'required|email|unique:customer,email',
            'phone' => 'required|unique:customer,phone',
        ]);
        $data = $request->only($this->requestInput);
        try {
            DB::beginTransaction();
            $data['password'] = Hash::make($data['password']);
            Customer::insert($data);
            DB::commit();
            return redirect()->route('customer.index')->with('notification_success', 'Thêm nhân viên thành công');
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
    public function show(Customer $customer)
    {
        if (!Gate::allows('role', ['role' => ['admin']])){
            return abort(403);
        }
        $data = [
            'row' => $customer,
            'action' => route('customer.update', ['customer' => $customer]),
            'method' => "PUT",
            'title' => "Sửa nhân viên {$customer->name}",
        ];
        return view('admin.customer.form', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        if (!Gate::allows('role', ['role' => ['admin']])){
            return abort(403);
        }
        $data = [
            'action' => route('customer.update', ['customer' => $customer]),
            'method' => "PUT",
            'title' => "Sửa nhân viên {$customer->name}",
        ];
        return view('admin.customer.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $data = array_filter($request->only($this->requestInput));
        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email|unique:customer,email,'. $customer->id,
            'phone' => 'required|unique:customer,phone,'. $customer->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            if (!empty($data['password'])) $data['password'] = Hash::make($data['password']);
            $customer->update($data);
            DB::commit();
            return redirect()->route('customer.index')->with('notification_success', 'Sửa nhân viên thành công');
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
    public function destroy(Customer $customer)
    {
        if (!Gate::allows('role', ['role' => ['admin']])){
            return abort(403);
        }
        if ($customer->delete()){
            return back()->with('notification_success', 'Xóa nhân viên thành công');
        }
        return back()->with('notification_error', 'Lỗi !!! Xóa nhân viên không thành công');
    }


}

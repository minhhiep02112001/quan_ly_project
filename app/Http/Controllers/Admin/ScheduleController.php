<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Progress;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        if ($request->has('str') && !empty($request->str)) {
            $data[] = ['name', 'like', "%{$request->str}%"];
        }
        $rows = Task::where(function ($query) use ($data) {
            if (!empty($data)){
                array_map(function ($item) use ($query){
                    return $query->orWhere(...$item);
                },$data);
            }
            if (Auth::user()->role == 'employee'){
                return $query->where('employee_id' , Auth::id());
            }
        })->paginate(10);
        $data = [
            'rows' => $rows->appends($request->all())
        ];
        return view('admin.schedule.index', $data);
        # code...
    }
}

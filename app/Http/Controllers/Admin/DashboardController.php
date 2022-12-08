<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function index(Request $request)
    {
        $year = date("Y");

        $statistical = Project::select(
            \DB::raw('SUM(cost) as total'),
            \DB::raw("EXTRACT(YEAR FROM `end_date`) as year"),
            \DB::raw("EXTRACT(MONTH FROM `end_date`) as month")
        )->where('status',2)
            ->whereBetween('end_date', ["$year-1-1", "$year-12-30"])
            ->groupBy('month', 'year')->orderBy('month', 'ASC')->get()->toArray();

        $statisticals = array_combine(array_column($statistical, 'month'), $statistical);
        $arr = [];
        for ($i=1 ; $i <=12 ; $i++){
            if (!empty($statisticals[$i])){
                $arr[] = (int)ceil($statisticals[$i]['total']);
            }else{
                $arr[] = 0;
            }
        }
        $data = [
            'count_employee' => User::all()->count(),
            'count_project' => Project::all()->count(),
            'count_customer' => Customer::all()->count(),
            'arr' => $arr
        ];
        return view('admin.index', $data);
    }
}

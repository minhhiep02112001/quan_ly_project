<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $table = 'table_progress';
    protected $fillable = ['employee_id' , 'task_id' , 'time_start' , 'time_end', 'progress', 'note','contract_files', 'status'];
    protected $primaryKey = 'id';
    function task(){
        return $this->belongsTo(Task::class, 'task_id' , 'id');
    }
    function employee(){
        return $this->belongsTo(User::class, 'employee_id' , 'id');
    }
}

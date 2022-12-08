<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'table_task';
    protected $fillable = ['name', 'project_id', 'employee_id', 'end_date', 'intend_time_start', 'intend_time_end', 'note', 'cost', 'status'];
    protected $primaryKey = 'id';

    function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    function progress()
    {
        return $this->hasMany(Progress::class, 'task_id', 'id');
    }

    function employee()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }
}

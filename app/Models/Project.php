<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'table_project';
    protected $fillable = ['name', 'customer_id', 'manager_id', 'intend_time_start', 'intend_time_end', 'start_date', 'end_date', 'note', 'estimate_cost' , 'cost' , 'contract_files' , 'status'];
    protected $primaryKey = 'id';

    const DRAFT = 0;
    const DRAFT_ALIAS = 'Khởi tạo';
    const OPEN = 1;
    const OPEN_ALIAS = 'Bắt đầu';
    const PENDING = 2;
    const PENDING_ALIAS = 'Đang làm';
    const APPROVED = 4;
    const APPROVED_ALIAS = 'Hoàn thành';
    const REJECT = 4;
    const REJECT_ALIAS = 'Hủy';

    function getStatus()
    {
        $status = '';
        switch ($this->status) {
            case self::DRAFT;
                $status = self::DRAFT_ALIAS;
                break;
            case self::OPEN;
                $status = self::OPEN_ALIAS;
                break;
            case self::PENDING;
                $status = self::PENDING_ALIAS;
                break;
            case self::REJECT;
                $status = self::REJECT_ALIAS;
                break;
            case self::APPROVED;
                $status = self::APPROVED_ALIAS;
        }
        return $status;
    }

    function tasks(){
        return $this->hasMany(Task::class, 'project_id' , 'id');
    }

    function employee(){
        return $this->belongsTo(User::class, 'manager_id' , 'id');
    }
}

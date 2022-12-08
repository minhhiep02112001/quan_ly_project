<?php

namespace App\Listeners;

use App\Models\Progress;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use function Symfony\Component\Translation\t;

class ListenerCreateTask
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        //
    }

    function renderProgress($data)
    {
        $task_id = $data['task_id'];

        $task = Task::find($task_id);
        if (empty($task)) return;
        $start_time = $task->intend_time_start;
        $end_time = $task->intend_time_end;

        $begin = new \DateTime($start_time);
        $end = new \DateTime("$end_time +1 day");
        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($begin, $interval, $end);

        foreach ($period as $dt){
            $start = $dt->format("Y-m-d"). " " . config('data.time_work.start');
            $end = $dt->format("Y-m-d"). " " . config('data.time_work.end');
            Progress::insert([
                'employee_id' => $task->employee_id ,
                'task_id' => $task_id ,
                'time_start' => $start ,
                'time_end' => $end,
                'progress' => 0,
            ]);
        }
        return true;
    }

    function updateProgressTask($task_id){
        $task = Task::find($task_id);
        if (empty($task)) return;
        $count_progress = $task->progress()->count();
        $progress_success = $task->progress()->where('status' , 2)->get();
        $task_progress = $progress_success->sum('progress');
        $ratio = (( $task_progress/$count_progress ) / 100) * 100;
        $task->progress = $ratio;
        $task->save();
    }
}

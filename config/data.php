<?php
return [
    'role' => [
        'admin' => 'CEO',
        'leader' => 'Team Leader',
        'employee' => 'Employee',
    ],
    'time_work' => [
        "start" => "08:00:00",
        "end" => "18:00:00",
    ],
    'project_status' => [
        '0' => array('text' => 'Chưa bắt đầu' , 'class'=>'bg-light-blue'),
        '1' => array('text' => 'Đang làm' , 'class'=>'bg-warning'),
        '2' => array('text' => 'Hoàn thành' , 'class'=>'bg-success'),
        '3' => array('text' => 'Chậm tiến độ' , 'class'=>'bg-warning'),
        '4' => array('text' => 'Hủy' , 'class'=>'bg-danger'),
    ],
    'task_status' => [
        '0' => array('text' => 'Chưa hoàn thành' , 'class'=>'bg-warning'),
        '1' => array('text' => 'Hoàn thành' , 'class'=>'bg-success'),
    ],
    'progress_status' => [
        '0' => array('text' => 'Chưa bắt đầu' , 'class'=>'bg-light-blue'),
        '1' => array('text' => 'Chờ phê duyệt' , 'class'=>'bg-warning'),
        '2' => array('text' => 'Hoàn thành' , 'class'=>'bg-success'),
    ]
];

?>

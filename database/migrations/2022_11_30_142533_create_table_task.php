<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_task', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Tên task');
            $table->integer('employee_id')->default(0)->comment('Nhân viên làm');
            $table->integer('project_id')->default(0)->comment('Nhân viên làm');
            $table->date('intend_time_start')->nullable()->comment('Thời gian dự định bắt đầu');
            $table->date('intend_time_end')->nullable()->comment('Thời gian dự định kết thúc');
            $table->date('end_date')->nullable()->comment('Ngày kết thúc');
            $table->string('progress')->default("0")->comment('Tiến độ');
            $table->string('note')->default(now())->comment('Ghi chú');
            $table->string('cost')->comment('Tổng chi phí');
            $table->tinyInteger('status')->default(0)->comment('Trạng thái');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_task');
    }
};

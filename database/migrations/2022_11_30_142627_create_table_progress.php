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
    public function up() // Báo cáo công việc hàng ngày
    {
        Schema::create('table_progress', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id')->default(0)->comment('Nhân viên làm');
            $table->integer('task_id')->default(0)->comment('Nhân viên làm');
            $table->dateTime('time_start')->nullable()->comment('Thời gian  bắt đầu');
            $table->dateTime('time_end')->nullable()->comment('Thời gian kết thúc');
            $table->tinyInteger('progress')->default(0)->comment('Tiến độ');
            $table->text('note')->nullable()->comment('Ghi chú công việc đã làm');
            $table->text('contract_files')->nullable()->comment('file hoặc hình ảnh minh họa');
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
        Schema::dropIfExists('table_progress');
    }
};

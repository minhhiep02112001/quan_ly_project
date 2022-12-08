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
        Schema::create('table_project', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Tên dự án');
            $table->integer('customer_id')->default(0)->comment('Khách hàng');
            $table->integer('manager_id')->default(0)->comment('Người quản lý dự án');
            $table->date('intend_time_start')->nullable()->comment('Thời gian dự định bắt đầu');
            $table->date('intend_time_end')->nullable()->comment('Thời gian dự định kết thúc');
            $table->date('start_date')->nullable()->comment('Ngày bắt đầu');
            $table->date('end_date')->nullable()->comment('Ngày kết thúc');
            $table->string('note')->default(now())->comment('Ghi chú');
            $table->string('estimate_cost')->comment('Dự toán chi phí');
            $table->string('cost')->comment('Tổng chi phí');
            $table->text('contract_files')->nullable()->comment('Hình ảnh hợp đồng');
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
        Schema::dropIfExists('table_project');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillLateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_late', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('day_late')->comment('Ngày trễ');
            $table->string('batch_late')->comment('Đợt trễ');
            $table->string('money_late')->comment('Số tiền trễ');
            $table->string('citation_rate')->comment('Lãi phạt');
            $table->integer('number_notifi')->comment('Số lần đã gửi thông báo');
            $table->string('document')->comment('Văn bản, phương thức');
            $table->date('receipt_date')->comment('Ngày khách nhận thông báo');
            $table->integer('payment_id');
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
        Schema::dropIfExists('bill_late');
    }
}

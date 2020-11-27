<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('payment_progress')->comment('Tiến độ thanh toán');
            $table->date('payment_date_95')->comment('Ngày thanh toán đủ 95%');
            $table->date('day_late')->comment('Ngày trễ')->nullable();
            $table->string('batch_late')->comment('Đợt trễ')->nullable();
            $table->double('money_late')->comment('Số tiền trễ')->nullable();
            $table->double('citation_rate')->comment('Lãi phạt')->nullable();
            $table->integer('number_notifi')->comment('Số lần đã gửi thông báo')->nullable();
            $table->string('document')->comment('Văn bản, phương thức')->nullable();
            $table->date('receipt_date')->comment('Ngày khách nhận thông báo')->nullable();
            $table->integer('contract_id')->nullable();
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
        Schema::dropIfExists('payments');
    }
}

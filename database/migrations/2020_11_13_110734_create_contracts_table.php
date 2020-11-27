<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('contract_no')->comment("Số hợp đồng");
            $table->float('area_signed')->comment("Diện tích kí");
            $table->integer('customer_id');
            $table->string('type')->comment("Loại hợp đồng");
            $table->boolean("signed")->comment("Đã kí hay chưa");
            $table->date("signed_date")->comment("Ngày kí");
            $table->string("value")->comment("Giá bán");
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
        Schema::dropIfExists('contracts');
    }
}

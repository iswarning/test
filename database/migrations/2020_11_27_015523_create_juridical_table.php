<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuridicalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('juridical', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contract_info')->comment('Thông tin hợp đồng');
            $table->string('status')->comment('Tình trạng sổ');
            $table->date('notarized_date')->comment('Ngày công chứng')->nullable();
            $table->string('registration_procedures')->comment('Thủ tục đăng bộ');
            $table->date('delivery_book_date')->comment('Ngày bàn giao sổ')->nullable();
            $table->tinyInteger('liquidation')->comment('Thanh lý hợp đồng');
            $table->string('bill_profile')->comment('Hồ sơ thu lai của khách hàng')->nullable();
            $table->string('book_holder')->comment('Bộ phận giữ sổ');
            $table->date('delivery_land_date')->comment('Ngày bàn giao đất')->nullable();
            $table->string('commitment')->comment('Cam kết thỏa thuận')->nullable();
            $table->integer('contract_id');
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
        Schema::dropIfExists('juridical');
    }
}

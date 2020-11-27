<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLotnumberAndStatusToContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->string("lot_number")->comment("Mã lô");
            $table->string("status")->comment("Trạng thái hợp đồng");
            $table->string("project_id")->comment("Mã dự án");
            $table->string("status_created_by")->nullable()->comment("Nhân viên hoặc khách nhận giữ chỗ");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            //
        });
    }
}

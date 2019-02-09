<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKpiOutputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kpi_outputs', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('input_date');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('user_key_in_id');
            $table->unsignedInteger('total_amount')->default(0);
            $table->unsignedInteger('total_defect')->default(0);
            $table->string('remark')->default("");
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
        Schema::dropIfExists('kpi_outputs');
    }
}

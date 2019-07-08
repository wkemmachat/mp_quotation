<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockRealTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_real_times', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_running_id')->nullable(false)->unique();
            $table->unsignedInteger('amount')->nullable(false);
            $table->unsignedInteger('transfer_in_out_id')->nullable(false);
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
        Schema::dropIfExists('stock_real_times');
    }
}

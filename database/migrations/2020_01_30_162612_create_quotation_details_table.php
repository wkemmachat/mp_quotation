<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_running_id')->nullable(false);
            $table->unsignedInteger('amount')->nullable(false);
            $table->string('remarkByProduct')->nullable(false);
            $table->double('discountPercentByProduct', 8, 2)->default('0.00');
            $table->unsignedInteger('quotation_main_running_id')->nullable(false);

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
        Schema::dropIfExists('quotation_details');
    }
}

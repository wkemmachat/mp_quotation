<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationMainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_mains', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('customer_running_id')->nullable(false);
            $table->unsignedInteger('user_key_in_id')->nullable(false);
            $table->string('PI_number')->nullable(false)->unique();
            $table->date('PI_date')->nullable(false);
            $table->double('shippingCostInPI', 8, 2)->default('0.00');
            $table->double('specialDiscount', 8, 2)->default('0.00');
            $table->string('depositPercentOrValue')->nullable(false); // ex percent
            $table->double('depositAmountPercentOrValue', 8, 2)->default('0.00'); // ex 50 mean deposite 50%
            $table->string('remarkInPI')->default('');
            $table->string('ref_PI_number')->default('');

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
        Schema::dropIfExists('quotation_mains');
    }
}

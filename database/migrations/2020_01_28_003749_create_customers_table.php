<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('customerName')->default("");
            $table->string('customerAddress1')->default("");
            $table->string('customerAddress2')->default("");
            $table->string('customerAddress3')->default("");
            $table->string('customerContactPerson')->default("");
            $table->string('customerTaxId')->default("");
            $table->string('customerTel')->default("");
            $table->string('customerMail')->default("");
            $table->string('remark')->default("");
            $table->unsignedInteger('user_key_in_id');
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
        Schema::dropIfExists('customers');
    }
}

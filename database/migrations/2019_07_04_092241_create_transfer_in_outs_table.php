<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferInOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_in_outs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_running_id')->nullable(false);
            $table->unsignedInteger('amount')->nullable(false);
            $table->unsignedInteger('user_key_in_id')->nullable(false);
            $table->string('remark')->default("");
            $table->string('document_reference_id')->nullable(false);
            $table->string('in_or_out')->nullable(false);
            $table->string('out_type')->default("");
            $table->date('input_date');
            $table->boolean('isConfirmed')->default(0);
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
        Schema::dropIfExists('transfer_in_outs');
    }
}

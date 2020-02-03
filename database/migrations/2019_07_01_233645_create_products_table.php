<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_key_in_id');
            $table->string('productId')->nullable(false)->unique();
            $table->string('productName')->nullable(false);
            $table->unsignedInteger('productCategoryRunning_id')->nullable(false);
            $table->string('remark')->default("");
            $table->string('imageName')->default("");
            $table->integer('min')->default(-1);
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->string('desc1')->default("");
            $table->string('desc2')->default("");
            $table->string('desc3')->default("");
            $table->string('desc4')->default("");
            $table->string('desc5')->default("");
            $table->string('desc6')->default("");
            $table->double('std_price', 8, 2)->default('0.00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

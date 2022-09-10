<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sell_master_id');
            $table->unsignedBigInteger('product_id');
            $table->string('product_name');
            $table->unsignedBigInteger('unit_id');
            $table->string('unit_form');
            $table->decimal('unit_price', 10, 2);
            $table->boolean('product_type');
            $table->unsignedBigInteger('color_id')->nullable();
            $table->string('variation_sku')->nullable();
            $table->decimal('item_qty');
            $table->decimal('item_subtotal', 10, 2);
            $table->decimal('item_discount', 10, 2);
            $table->decimal('item_total', 10, 2);
            $table->boolean('status');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('sell_master_id')->references('id')->on('sell_masters')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sell_items');
    }
}

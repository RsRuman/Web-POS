<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bus_org_id');
            $table->unsignedBigInteger('customer_id');
            $table->string('invoice_no');
            $table->decimal('total_qty');
            $table->decimal('sub_total_amount');
            $table->decimal('discount_amount');
            $table->decimal('total_amount');
            $table->decimal('due_amount');
            $table->boolean('status');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('bus_org_id')->references('id')->on('business_organizations')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sell_masters');
    }
}

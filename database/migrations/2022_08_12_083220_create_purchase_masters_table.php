<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bus_org_id');
            $table->unsignedBigInteger('supplier_id');
            $table->string('invoice_no');
            $table->dateTime('purchase_date');
            $table->decimal('total_qty');
            $table->decimal('sub_total', 10, 2);
            $table->decimal('discount_amount', 10, 2);
            $table->decimal('due_amount', 10, 2);
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
        Schema::dropIfExists('purchase_masters');
    }
}

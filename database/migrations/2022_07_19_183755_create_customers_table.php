<?php

use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->unsignedBigInteger('bus_org_id');
            $table->string("customer_code");
            $table->string("customer_name");
            $table->string("customer_phone")->nullable();
            $table->string("customer_email")->nullable();
            $table->string("customer_address")->nullable();
            $table->decimal("customer_due", 10, 2)->nullable();
            $table->decimal("customer_advance", 10, 2)->nullable();
            $table->boolean('status')->default(Customer::Status['Active']);
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
        Schema::dropIfExists('customers');
    }
}

<?php

use App\Models\BusinessOrganization;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_organizations', function (Blueprint $table) {
            $table->id();
            $table->string('bus_name');
            $table->string('bus_phone_no')->unique();
            $table->string('bus_email')->unique();
            $table->boolean('bus_type');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('upazila_id');
            $table->string('postal_code');
            $table->boolean('status')->default(BusinessOrganization::Status['Active']);
            $table->softDeletes();
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
        Schema::dropIfExists('business_organizations');
    }
}

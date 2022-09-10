<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bus_org_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('category_name');
            $table->string('category_slug')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('status')->default(Category::Status['Active']);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('categories')->cascadeOnDelete();
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
        Schema::dropIfExists('categories');
    }
}

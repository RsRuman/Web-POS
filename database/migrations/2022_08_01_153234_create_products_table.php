<?php

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->unsignedBigInteger('bus_org_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('color_id')->nullable();
            $table->unsignedBigInteger('size_id')->nullable();
            $table->string('product_name');
            $table->string('product_code');
            $table->string('product_slug');
            $table->decimal('product_price', 10, 2);
            $table->float('product_stock_qty');
            $table->float('low_stock');
            $table->text('product_details')->nullable();
            $table->text('product_barcode')->nullable();
            $table->boolean('is_variant')->nullable();
            $table->boolean('status')->default(Product::Status['Active']);
            $table->softDeletes();

            $table->timestamps();

            $table->foreign('bus_org_id')->references('id')->on('business_organizations')->cascadeOnDelete();
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
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

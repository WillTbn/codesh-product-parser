<?php

use App\Enums\ProductStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('code')->nullable();
            $table->enum('status', ProductStatus::forSelectName());
            $table->timestamp('imported_t');
            $table->text('url')->nullable();
            $table->string('creator')->nullable();
            $table->integer('created_t')->nullable();
            $table->integer('last_modified_t')->nullable();
            $table->string('product_name')->nullable();
            $table->string('quantity')->nullable();
            $table->string('brands')->nullable();
            $table->text('categories')->nullable();
            $table->text('labels')->nullable();
            $table->string('cities')->nullable();
            $table->string('purchase_places')->nullable();
            $table->string('stores')->nullable();
            $table->text('ingredients_text')->nullable();
            $table->string('traces')->nullable();
            $table->string('serving_size')->nullable();
            $table->float('serving_quantity')->nullable();
            $table->integer('nutriscore_score')->nullable();
            $table->string('nutriscore_grade')->nullable();
            $table->string('main_category')->nullable();
            $table->text('image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

<?php

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
        Schema::create('materials_library', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('material_company_id')->nullable();
            $table->unsignedBigInteger('material_category_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->decimal('selling_price', 15, 2)->nullable();
            $table->decimal('purchase_price', 15, 2)->nullable();
            $table->decimal('weight_per_piece', 8, 1)->nullable();
            $table->decimal('panel_wattage', 8, 1)->nullable();
            $table->decimal('gst', 5, 2)->nullable();
            $table->text('search_tags')->nullable();
            $table->string('hsn_sac')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials_library');
    }
};

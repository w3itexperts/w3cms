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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('invoice_id');
            $table->string('item_id')->nullable();
            $table->integer('material_company_id')->nullable();
            $table->integer('material_category_id')->nullable();
            $table->string('item_title');
            $table->string('item_unit')->nullable();
            $table->integer('item_quantity')->default(0);
            $table->decimal('rates_per_units', 15, 2)->default(0);
            $table->decimal('gst', 4, 1)->nullable()->default(0);
            $table->decimal('discount', 4, 1)->nullable()->default(0);
            $table->decimal('amount', 15, 2)->nullable()->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};

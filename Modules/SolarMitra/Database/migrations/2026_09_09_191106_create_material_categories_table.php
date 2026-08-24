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
        Schema::create('material_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->boolean('display_on_invoice')->default(false);
            $table->boolean('calculate_in_invoice')->default(false);
            $table->boolean('include_in_solar_kit')->nullable()->default(false);
            $table->integer('order')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->decimal('gst', 15, 2)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_categories');
    }
};

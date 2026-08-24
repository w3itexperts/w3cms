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
        Schema::create('material_companies_material_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('material_company_id')->nullable();
            $table->unsignedBigInteger('material_category_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_companies_material_categories');
    }
};

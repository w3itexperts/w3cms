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
        Schema::create('contractors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('contact_id');
            $table->string('contractor_type', 50)->nullable();
            $table->integer('team_size')->nullable();
            $table->string('skill_category', 100)->nullable();
            $table->decimal('labor_rate_per_kw', 10, 2)->nullable();
            $table->string('service_area', 150)->nullable();
            $table->integer('experience_years')->nullable();
            $table->string('license_no', 100)->nullable();
            $table->boolean('availability_status')->nullable()->default(true);
            $table->decimal('rating', 3, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contractors');
    }
};

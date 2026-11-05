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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('contact_id');
            $table->string('supplier_category', 100)->nullable();
            $table->string('brand_name', 100)->nullable();
            $table->string('gst_no', 20)->nullable();
            $table->string('pan_no', 20)->nullable();
            $table->string('payment_terms', 100)->nullable();
            $table->integer('delivery_time_days')->nullable();
            $table->string('service_area', 150)->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->boolean('status')->nullable()->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};

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
        Schema::create('partners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('contact_id');
            $table->string('partner_type', 50)->nullable();
            $table->decimal('commission_percent', 5, 2)->nullable();
            $table->dateTime('partnership_start_date')->nullable();
            $table->dateTime('partnership_end_date')->nullable();
            $table->string('region', 100)->nullable();
            $table->string('sales_target')->nullable();
            $table->boolean('status')->nullable()->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};

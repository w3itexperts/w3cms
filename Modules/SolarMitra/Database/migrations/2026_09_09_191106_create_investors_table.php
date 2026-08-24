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
        Schema::create('investors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('contact_id');
            $table->string('investment_type', 50)->nullable();
            $table->decimal('investment_amount', 15, 2)->nullable();
            $table->decimal('equity_percent', 5, 2)->nullable();
            $table->dateTime('investment_date')->nullable();
            $table->decimal('expected_roi', 5, 2)->nullable();
            $table->string('payout_frequency', 50)->nullable();
            $table->string('contract_document')->nullable();
            $table->boolean('status')->nullable()->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investors');
    }
};

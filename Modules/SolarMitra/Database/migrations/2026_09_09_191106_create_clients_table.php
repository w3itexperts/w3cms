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
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('contact_id');
            $table->string('client_code', 50)->nullable();
            $table->string('client_type', 50)->nullable();
            $table->dateTime('customer_since')->nullable();
            $table->unsignedBigInteger('account_manager_id')->nullable();
            $table->decimal('credit_limit', 12, 2)->nullable();
            $table->string('payment_terms', 100)->nullable();
            $table->string('preferred_contact_method', 50)->nullable();
            $table->boolean('priority_level')->nullable();
            $table->boolean('status')->nullable()->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};

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
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('quotation_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('business_id')->nullable();
            $table->string('invoice_number');
            $table->string('title')->nullable();
            $table->decimal('paid_amount', 15, 2)->nullable()->default(0);
            $table->decimal('due_amount', 15, 2)->nullable()->default(0);
            $table->dateTime('date')->nullable()->useCurrent();
            $table->decimal('sub_total', 15, 2)->default(0);
            $table->decimal('tax', 4, 1)->default(0);
            $table->decimal('aditional_charges', 15, 2)->default(0);
            $table->decimal('discount', 4, 1)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->dateTime('due_date')->nullable()->useCurrent();
            $table->tinyInteger('status')->default(1)->comment('1. Unpaid
2. Paid
');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};

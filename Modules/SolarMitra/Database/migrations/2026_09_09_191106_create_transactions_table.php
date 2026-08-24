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
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('business_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('transaction_type_id')->nullable();
            $table->unsignedBigInteger('sender_party_id')->nullable();
            $table->unsignedBigInteger('reciever_party_id')->nullable();
            $table->string('transaction_number')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->text('description')->nullable();
            $table->timestamp('date')->nullable();
            $table->tinyInteger('transfer_mode')->nullable()->comment('\'1\' => \'Cash\',
\'2\' => \'Bank Transfer\',
\'3\' => \'Cheque\',');
            $table->string('transfer_type')->nullable()->comment('DR - Debit
CR - Credit');
            $table->tinyInteger('payment_for')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('reference_type', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

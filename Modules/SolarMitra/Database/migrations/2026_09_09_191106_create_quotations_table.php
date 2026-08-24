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
        Schema::create('quotations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->unsignedBigInteger('business_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('title')->nullable();
            $table->string('quotation_number')->nullable();
            $table->dateTime('date')->nullable()->useCurrent();
            $table->decimal('sub_total', 10, 2)->default(0);
            $table->decimal('tax', 4, 2)->default(0);
            $table->decimal('aditional_charges', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->dateTime('valid_till_date')->nullable()->useCurrent();
            $table->tinyInteger('quotation_status_id')->default(1)->comment('1. draft
2. sent -> public Quot
3. in discussion
4. on hold
5. client confirmed - convert
6. rejected - deleted');
            $table->unsignedBigInteger('margin_amount')->nullable();
            $table->text('description')->nullable();
            $table->boolean('invoice_generated')->nullable()->default(false);
            $table->bigInteger('created_by')->nullable()->comment('logged in user id that created the quotation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};

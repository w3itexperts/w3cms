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
        Schema::create('staff', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('contact_id');
            $table->string('employee_code', 50)->nullable();
            $table->string('department', 100)->nullable();
            $table->string('designation', 100)->nullable();
            $table->dateTime('joining_date')->nullable();
            $table->string('employment_type', 50)->nullable();
            $table->string('salary_type', 50)->nullable();
            $table->decimal('salary_amount', 10, 2)->nullable();
            $table->unsignedBigInteger('reporting_manager_id')->nullable();
            $table->string('work_location', 100)->nullable();
            $table->boolean('status')->nullable()->default(true);
            $table->text('work_responsibilities')->nullable();
            $table->text('special_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};

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
        Schema::create('project_dates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id');
            $table->timestamp('document_varify_date')->nullable();
            $table->timestamp('name_correction_date')->nullable();
            $table->timestamp('name_transfer_date')->nullable();
            $table->timestamp('subsidi_registration_date')->nullable();
            $table->timestamp('loan_doc_submit_date')->nullable();
            $table->timestamp('bank_verification_date')->nullable();
            $table->timestamp('loan_disberment_date')->nullable();
            $table->timestamp('panel_work_date')->nullable();
            $table->timestamp('cabling_work_date')->nullable();
            $table->timestamp('civil_work_date')->nullable();
            $table->timestamp('handover_date')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_dates');
    }
};

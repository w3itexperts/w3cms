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
        Schema::create('project_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id');
            $table->boolean('government_subsidy')->nullable()->default(false);
            $table->boolean('selected_subsidy_type')->nullable();
            $table->string('electricity_bill')->nullable();
            $table->boolean('electricity_bill_verification_status')->nullable()->default(false);
            $table->string('adhar_card')->nullable();
            $table->string('adhar_card_backside')->nullable();
            $table->boolean('adhar_card_verification_status')->nullable()->default(false);
            $table->string('pancard')->nullable();
            $table->boolean('pancard_verification_status')->nullable()->default(false);
            $table->string('bank_passbook')->nullable();
            $table->boolean('bank_passbook_verification_status')->nullable()->default(false);
            $table->string('name_correction_new_name')->nullable();
            $table->boolean('name_correction_new_name_status')->nullable()->default(false);
            $table->string('noc_name_transfer')->nullable();
            $table->boolean('noc_name_transfer_status')->nullable()->default(false);
            $table->string('property_patta_evidence')->nullable();
            $table->boolean('property_patta_evidence_verification_status')->nullable()->default(false);
            $table->boolean('subsidi_registration_status')->nullable()->default(false);
            $table->boolean('loan_doc_submit_status')->nullable()->default(false);
            $table->boolean('bank_verification_status')->nullable()->default(false);
            $table->boolean('loan_disberment_status')->nullable()->default(false);
            $table->boolean('structure_work_status')->nullable()->default(false);
            $table->boolean('panel_work_status')->nullable()->default(false);
            $table->boolean('cabling_work_status')->nullable()->default(false);
            $table->boolean('civil_work_status')->nullable()->default(false);
            $table->boolean('netmeter_file_submission')->nullable()->default(false);
            $table->boolean('netmeter_site_visited')->nullable()->default(false);
            $table->boolean('netmeter_demand_note_generated')->nullable()->default(false);
            $table->boolean('netmeter_demand_note_paid')->nullable()->default(false);
            $table->boolean('netmeter_installed')->nullable()->default(false);
            $table->string('netmeter_photo')->nullable();
            $table->boolean('netmeter_plant_on')->default(false);
            $table->string('netmeter_plant_photo')->nullable();
            $table->string('handover_confirmation_signature')->nullable();
            $table->boolean('handover_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_documents');
    }
};

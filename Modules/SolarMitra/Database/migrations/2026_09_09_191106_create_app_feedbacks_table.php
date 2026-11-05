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
        Schema::create('app_feedbacks', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('user_id');

            $table->enum('feedback_type', [
                'Suggestion',
                'Issue',
                'Feature Request',
                'Improvement',
                'Other'
            ]);

            $table->string('subject', 200);
            $table->text('description');

            $table->string('attachment', 255)->nullable();

            $table->enum('priority', [
                'Low',
                'Medium',
                'High'
            ])->default('Medium');

            $table->enum('status', [
                'New',
                'In Review',
                'In Progress',
                'Completed',
                'Rejected'
            ])->default('New');

            $table->string('module_name', 100)->nullable();
            $table->string('page_url', 255)->nullable();
            $table->string('browser', 100)->nullable();
            $table->string('operating_system', 100)->nullable();
            $table->string('app_version', 50)->nullable();
            $table->string('ip_address', 45)->nullable();

            $table->text('admin_remark')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_feedbacks');
    }
};
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
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('business_id');
            $table->string('title');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->text('location')->nullable();
            $table->dateTime('start_date')->nullable()->useCurrent();
            $table->dateTime('end_date')->nullable()->useCurrent();
            $table->string('capacity')->nullable();
            $table->smallInteger('capacity_int');
            $table->string('capacity_unit');
            $table->decimal('project_value', 15, 2)->nullable();
            $table->text('change_note')->nullable()->comment('after project start automatically change log will save on every edit into dates , amounts by appending with last note

clients and titles can not change after project start');
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1. Draft
2. Running
3. Completed
4. Hold
5. Archived');
            $table->string('project_type')->nullable();
            $table->boolean('is_solar_kit_project')->nullable()->default(false)->comment('0 => no
1 => yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

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
        Schema::create('business_config_master', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('config_master_id');
            $table->unsignedBigInteger('business_id');
            $table->string('display_title');
            $table->string('field_key');
            $table->text('field_value')->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_config_master');
    }
};

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
        Schema::create('campaign_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('channel_id')->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->string('name');
            $table->string('external_ref')->nullable();
            $table->decimal('cost', 15, 2)->nullable()->default(0);
            $table->unsignedInteger('lead_count')->nullable()->default(0);
            $table->unsignedInteger('impression')->nullable()->default(0);
            $table->unsignedInteger('clicks')->nullable()->default(0);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_activities');
    }
};

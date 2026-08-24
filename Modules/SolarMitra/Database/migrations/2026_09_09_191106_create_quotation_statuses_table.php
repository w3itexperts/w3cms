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
        Schema::create('quotation_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug', 50)->unique('slug');
            $table->string('title', 100);
            $table->integer('order_no');
            $table->boolean('is_public')->nullable()->default(false)->comment('Visible to client');
            $table->boolean('can_edit')->nullable()->default(false);
            $table->boolean('can_convert')->nullable()->default(false)->comment('Convert quotation to order');
            $table->boolean('is_final')->nullable()->default(false)->comment('No further status change');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_statuses');
    }
};

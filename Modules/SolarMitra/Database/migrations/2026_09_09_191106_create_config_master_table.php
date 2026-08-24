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
        Schema::create('config_master', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('module_code', 100)->comment('\'Global\',
\'Staff\',
\'Invoice\',
\'Quotation\',
\'Lead\',
\'Tax\',
\'Solor\',
\'Projects\',
\'Documents\',');
            $table->string('field_key', 150);
            $table->string('display_title');
            $table->text('description')->nullable();
            $table->string('industry_code', 100)->nullable();
            $table->string('config_group', 100)->nullable();
            $table->string('value_type', 50)->nullable();
            $table->string('field_type', 100)->nullable();
            $table->longText('options_json')->nullable();
            $table->text('field_value')->nullable();
            $table->longText('validation_rules_json')->nullable();
            $table->boolean('is_required')->nullable()->default(false);
            $table->boolean('is_readonly')->nullable()->default(false);
            $table->boolean('is_hidden')->nullable()->default(false);
            $table->boolean('is_multiple')->nullable()->default(false);
            $table->decimal('min_value', 15, 4)->nullable();
            $table->decimal('max_value', 15, 4)->nullable();
            $table->decimal('step_value', 15, 4)->nullable();
            $table->string('regex_pattern', 500)->nullable();
            $table->string('depends_on_key', 150)->nullable();
            $table->string('depends_on_value')->nullable();
            $table->integer('display_order')->nullable()->default(0);
            $table->text('help_text')->nullable();
            $table->boolean('is_active')->nullable()->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config_master');
    }
};

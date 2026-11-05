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
        if (Schema::hasTable('roles')) {
            Schema::table('roles', function (Blueprint $table) {
                
                $table->unsignedBigInteger('business_id')->nullable()->after('id');

                $table->unsignedBigInteger('parent_id')->nullable()->after('business_id');

                $table->text('description')->nullable()->after('parent_id');

                $table->boolean('status')->default(true)->after('description');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn([
                'business_id',
                'parent_id',
                'description',
                'status',
            ]);
        });
    }
};

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
        if (Schema::hasTable('contacts')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
                $table->unsignedBigInteger('business_id')->nullable()->after('user_id');
                $table->string('name')->nullable()->after('business_id');
                $table->tinyInteger('type')->nullable()->default(2)->comment('\'1\' => \'Business\',
            \'2\' => \'Business User\',')->after('message');
                $table->string('company_name')->nullable()->after('type');
                $table->string('aadhar_no', 20)->nullable()->after('company_name');
                $table->string('pan_no', 20)->nullable()->after('aadhar_no');
                $table->string('gst_no', 20)->nullable()->after('pan_no');
                $table->string('zip', 10)->nullable()->after('gst_no');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn([
                'user_id',
                'business_id',
                'name',
                'type',
                'company_name',
                'aadhar_no',
                'pan_no',
                'gst_no',
                'zip',
            ]);
        });
    }
};

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
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                
                $table->string('mobile', 255)->nullable()->index()->after('email_verified_at');

                $table->string('otp', 255)->nullable()->after('mobile');

                $table->timestamp('mobile_verified_at')->nullable()->after('otp');

                $table->timestamp('otp_expires_at')->nullable()->after('mobile_verified_at');

                $table->enum('otp_type', ['email', 'mobile'])->nullable()->after('otp_expires_at');

                $table->boolean('is_mobile_verified')->default(0)->after('otp_type');

                $table->boolean('is_email_verified')->default(0)->after('is_mobile_verified');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'mobile',
                'otp',
                'mobile_verified_at',
                'otp_expires_at',
                'otp_type',
                'is_mobile_verified',
                'is_email_verified',
            ]);
        });
    }
};

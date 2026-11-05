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
        Schema::create('project_attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('attachment_id');
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('type')->comment('\'1\' => \'Site Photo\',
        \'2\' => \'Site Completion Photos\',
        \'3\' => \'Feedback\',
        \'4\' => \'Structure\',
        \'5\' => \'Panel Installation\',');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_attachments');
    }
};

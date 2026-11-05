<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w3app_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('w3app_id');
            $table->string('title')->nullable();
            $table->text('detail')->nullable();
            $table->string('file');
            $table->string('type');
            $table->timestamps();
            
            $table->foreign('w3app_id')->references('id')->on('w3apps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('w3app_files');
    }
};

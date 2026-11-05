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
        Schema::create('installed_w3apps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('w3app_id');
            $table->string('domain');
            $table->enum('status', ['A', 'I'])->comment('A - Active', 'Inactive');
            $table->datetime('deleted')->nullable();
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
        Schema::dropIfExists('installed_w3apps');
    }
};

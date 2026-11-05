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
        Schema::create('w3apps', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('author_id');
            $table->string('author_email');
            $table->string('preview_image')->nullable();
            $table->text('screenshots')->nullable();
            $table->string('package_zip');
            $table->text('keywords')->nullable();
            $table->text('feature_tags')->nullable();
            $table->enum('technology_platform', ['L', 'PD', 'C', 'CK'])->comment('L => Laravel, PD => Python dJango, C => Codeigniter, CK => CakePHP');
            $table->string('demo_link');
            $table->string('documentation_link');
            $table->longText('description')->nullable();
            $table->enum('type', ['T', 'P'])->comment('T => Theme, P => Plugin');
            $table->integer('downloads')->default('0')->nullable();
            $table->datetime('launching_date')->nullable();
            $table->enum('status', ['D', 'L', 'P', 'TM'])->comment('DM => Development Mode, L => Live, PM => Planing Mode, TM => Testing Mode');
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('w3apps');
    }
};

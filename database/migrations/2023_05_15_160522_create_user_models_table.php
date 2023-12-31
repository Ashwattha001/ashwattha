<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('mobile')->unique();
            $table->string('password');
            $table->string('role');
            $table->string('pan_number')->nullable();
            $table->string('pan_file')->nullable();
            $table->string('aadhar_number')->nullable();
            $table->string('aadhar_file')->nullable();
            $table->string('photo_file')->nullable();
            $table->tinyInteger('delete')->default('0');
            $table->tinyInteger('is_active')->default('0');
            $table->integer('a_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};

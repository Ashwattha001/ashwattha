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
        Schema::create('convereted_auto_values', function (Blueprint $table) {
            $table->id();
            $table->integer('architecture_no')->nullable();
            $table->integer('interior_no')->nullable();
            $table->integer('landscape_no')->nullable();
            $table->integer('sustainable_no')->nullable();
            $table->integer('cur_yr')->nullable();
            $table->integer('nxt_yr')->nullable();
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
        Schema::dropIfExists('convereted_auto_values');
    }
};

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
        Schema::create('visit_instructions', function (Blueprint $table) {
            $table->id();
            $table->integer('site_visit_id')->nullable();                                       // Site Visit Id 
            $table->date('instr_date')->nullable();                                             // instr date
            $table->string('instructions')->nullable();                                         // instructions
            $table->string('act_req_form')->nullable();                                         // act_req_form
            $table->integer('u_id')->nullable();                                                // created instru by user id
            $table->integer('a_id')->nullable();                                                // a_id
            $table->tinyInteger('delete')->default('0');
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
        Schema::dropIfExists('visit_instructions');
    }
};

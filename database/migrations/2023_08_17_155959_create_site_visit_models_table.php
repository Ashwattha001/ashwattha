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
        Schema::create('site_visits', function (Blueprint $table) {
            $table->id();
            $table->string('project_type')->nullable();                                 // project_type
            $table->integer('pr_id')->nullable();                                       // Conv Project Id 
            $table->date('visit_date')->nullable();                                     // visit date
            $table->string('stage_contr')->nullable();                                  // stage of constrction
            $table->string('visit_no')->nullable();                                     // auto visit no
            $table->integer('u_id')->nullable();                                        // created visit by user id
            $table->integer('a_id')->nullable();                                        // a_id
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
        Schema::dropIfExists('site_visits');
    }
};

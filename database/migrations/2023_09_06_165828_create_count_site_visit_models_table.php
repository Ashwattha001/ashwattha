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
        Schema::create('count_site_visits', function (Blueprint $table) {
            $table->id();
            $table->string('project_type')->nullable();                                  // project type
            $table->integer('pr_id')->nullable();                                       // Conv Project Id 
            $table->string('visit_count')->nullable();                                  // Conv Project Id 
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
        Schema::dropIfExists('count_site_visits');
    }
};

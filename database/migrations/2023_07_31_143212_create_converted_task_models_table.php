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
        Schema::create('converted_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('project_type')->nullable();                                 // project_type
            $table->integer('conv_pr_id')->nullable();                                  // Conv Project Id 
            $table->string('team_member')->nullable();                                  // team_member
            $table->integer('assign_id')->nullable();                                   // Who Assign Task
            $table->date('task_date')->nullable();                                      // task_date
            $table->date('end_date')->nullable();                                       // end_date
            $table->string('task_remark')->nullable();                                  // task_remark
            $table->string('employee_remark')->nullable();                              // employee_remark
            $table->string('task_status')->nullable();                                  // task_status
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
        Schema::dropIfExists('converted_tasks');
    }
};

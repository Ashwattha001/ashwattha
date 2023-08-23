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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('enquiry_no')->nullable();                                       // enquiry_no 
            $table->string('project_name')->nullable();                                     // project_name
            $table->string('client_name')->nullable();                                      // client_name
            $table->string('client_ph_no')->nullable();                                     // client_ph_no
            $table->date('enq_date')->nullable();                                           // enq_date
            $table->string('pr_address')->nullable();                                       // pr_address
            $table->string('client_requirement')->nullable();                               // client_requirement
            $table->string('client_document')->nullable();                                  // client_document
            $table->string('project_type')->nullable();                                     // project_type
            $table->string('pr_head_conceptual')->nullable();                               // pr_head_conceptual
            $table->string('team_member_conceptual')->nullable();                           // team_member_conceptual
            $table->string('site_supervisor')->nullable();                                  // site_supervisor
            $table->string('converted_no')->nullable();                                     // converted_no
            $table->string('pr_head_working')->nullable();                                  // pr_head_working
            $table->string('team_member_working')->nullable();                              // team_member_working
            $table->string('ar_plot')->nullable();                                          // ar_plot
            $table->string('constr_area')->nullable();                                      // constr_area
            $table->date('converted_date')->nullable();                                     // converted_date
            $table->string('consultants')->nullable();                                      // consultants
            $table->string('contractor')->nullable();                                       // contractor
            $table->string('enq_status')->default('Enquiry');                               // enq_status
            $table->string('converted_status')->nullable();                                 // converted_status
            $table->integer('a_id')->nullable();                                            // a_id
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
        Schema::dropIfExists('projects');
    }
};

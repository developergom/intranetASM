<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        if (!Schema::hasTable('action_plans')) {     
            Schema::create('action_plans', function (Blueprint $table) {
                $table->increments('action_plan_id');
                $table->integer('action_type_id');
                $table->string('action_plan_title', 150);
                $table->text('action_plan_desc');
                $table->date('action_plan_startdate');
                $table->date('action_plan_enddate');
                $table->enum('active',['0','1'])->default('1');
                $table->integer('created_by');
                $table->integer('updated_by')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('action_plans');
    }
}

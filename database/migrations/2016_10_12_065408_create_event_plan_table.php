<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('event_plans')) {
            Schema::create('event_plans', function (Blueprint $table) {
                $table->increments('event_plan_id');
                $table->integer('event_type_id');
                $table->string('event_plan_name');
                $table->text('event_plan_desc');
                $table->integer('event_plan_viewer');
                $table->string('event_plan_location');
                $table->date('event_plan_deadline');
                $table->char('event_plan_year', 4);
                $table->integer('flow_no');
                $table->integer('revision_no');
                $table->integer('current_user');
                $table->enum('active', ['0', '1'])->default('1');
                $table->integer('created_by');
                $table->integer('updated_by');
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
        Schema::dropIfExists('event_plans');
    }
}

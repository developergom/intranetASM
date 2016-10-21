<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateActionPlanTableAddColumnActionPlanPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('action_plans')) {
            Schema::table('action_plans', function($table) {
                DB::statement('ALTER TABLE action_plans ADD action_plan_rubric_desc TEXT AFTER action_plan_enddate');
                DB::statement('ALTER TABLE action_plans ADD action_plan_pages INTEGER AFTER action_plan_enddate');
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
        //
    }
}

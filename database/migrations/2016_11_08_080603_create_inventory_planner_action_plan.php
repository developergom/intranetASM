<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryPlannerActionPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('inventory_planner_action_plan')) {
            Schema::create('inventory_planner_action_plan', function (Blueprint $table) {
                $table->integer('inventory_planner_id');
                $table->integer('action_plan_id');
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
        Schema::dropIfExists('inventory_planner_action_plan');
    }
}

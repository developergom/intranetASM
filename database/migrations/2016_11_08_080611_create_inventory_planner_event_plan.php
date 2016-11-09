<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryPlannerEventPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('inventory_planner_event_plan')) {
            Schema::create('inventory_planner_event_plan', function (Blueprint $table) {
                $table->integer('inventory_planner_id');
                $table->integer('event_plan_id');
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
        Schema::dropIfExists('inventory_planner_event_plan');
    }
}

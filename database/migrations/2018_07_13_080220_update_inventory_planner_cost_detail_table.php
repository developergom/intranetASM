<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInventoryPlannerCostDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('inventory_planner_cost_details')) {
            Schema::table('inventory_planner_cost_details', function($table) {
                DB::statement("ALTER TABLE inventory_planner_cost_details ADD inventory_planner_cost_details_id int NOT NULL PRIMARY KEY AUTO_INCREMENT AFTER inventory_planner_id");
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

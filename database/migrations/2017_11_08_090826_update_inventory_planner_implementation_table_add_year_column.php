<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInventoryPlannerImplementationTableAddYearColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('inventory_planner_implementation')) {
            Schema::table('inventory_planner_implementation', function($table) {
                DB::statement("ALTER TABLE inventory_planner_implementation ADD year CHAR(4) AFTER implementation_id");
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

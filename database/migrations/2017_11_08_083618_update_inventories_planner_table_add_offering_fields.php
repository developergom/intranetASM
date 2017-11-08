<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInventoriesPlannerTableAddOfferingFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('inventories_planner')) {
            Schema::table('inventories_planner', function($table) {
                DB::statement("ALTER TABLE inventories_planner ADD inventory_source_id INTEGER DEFAULT 1 AFTER inventory_category_id");
                DB::statement("ALTER TABLE inventories_planner ADD inventory_planner_cost DOUBLE DEFAULT 0 AFTER inventory_planner_year");
                DB::statement("ALTER TABLE inventories_planner ADD inventory_planner_media_cost_print DOUBLE DEFAULT 0 AFTER inventory_planner_cost");
                DB::statement("ALTER TABLE inventories_planner ADD inventory_planner_media_cost_other DOUBLE DEFAULT 0 AFTER inventory_planner_media_cost_print");
                DB::statement("ALTER TABLE inventories_planner ADD inventory_planner_total_offering DOUBLE DEFAULT 0 AFTER inventory_planner_media_cost_other");
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

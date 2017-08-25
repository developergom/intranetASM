<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInventoriesTableAddColumnInventoryCategoryIdAndColumnInventoryParticipants extends Migration
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
                DB::statement("ALTER TABLE inventories_planner ADD inventory_category_id INTEGER AFTER inventory_type_id");
                DB::statement("ALTER TABLE inventories_planner ADD inventory_planner_participants INTEGER DEFAULT 0 AFTER inventory_planner_deadline");
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

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInventoriesPlannerTableAlterInventoryTypeIdColumn extends Migration
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
                DB::statement('ALTER TABLE inventories_planner CHANGE inventory_type_id proposal_type_id INTEGER');
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

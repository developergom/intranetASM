<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInventoryPlannerPrintCreativePricesTableRenameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('inventory_planner_print_creative_prices')) {
            Schema::table('inventory_planner_print_creative_prices', function($table) {
                DB::statement('ALTER TABLE inventory_planner_print_creative_prices RENAME inventory_planner_creative_prices');
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

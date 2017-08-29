<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryCategoryInventoryPlannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('inventory_category_inventory_planner')) {
            Schema::create('inventory_category_inventory_planner', function (Blueprint $table) {
                $table->integer('inventory_category_id');
                $table->integer('inventory_planner_id');
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
        Schema::dropIfExists('inventory_category_inventory_planner');
    }
}

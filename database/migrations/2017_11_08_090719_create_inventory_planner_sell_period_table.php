<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryPlannerSellPeriodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('inventory_planner_sell_period')) {
            Schema::create('inventory_planner_sell_period', function (Blueprint $table) {
                $table->integer('inventory_planner_id');
                $table->integer('sell_period_id');
                $table->char('year');
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
        Schema::dropIfExists('inventory_planner_sell_period');
    }
}

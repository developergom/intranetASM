<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryPlannerCostDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('inventory_planner_cost_details')){
            Schema::create('inventory_planner_cost_details', function(Blueprint $table){
                $table->integer('inventory_planner_id');
                $table->double('inventory_planner_cost');
                $table->double('inventory_planner_media_cost_print');
                $table->double('inventory_planner_media_cost_other');
                $table->double('inventory_planner_total_offering');
                $table->enum('status', ['0', '1'])->default('0');
                $table->integer('revision_no');
                $table->timestamps();
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
        Schema::dropIfExists('inventory_planner_cost_details');
    }
}

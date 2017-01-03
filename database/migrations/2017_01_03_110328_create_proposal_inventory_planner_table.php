<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalInventoryPlannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('proposal_inventory_planner')) {
            Schema::create('proposal_inventory_planner', function (Blueprint $table) {
                $table->integer('proposal_id');
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
        Schema::dropIfExists('proposal_inventory_planner');
    }
}

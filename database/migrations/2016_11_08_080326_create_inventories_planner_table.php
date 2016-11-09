<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesPlannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('inventories_planner')) {
            Schema::create('inventories_planner', function (Blueprint $table) {
                $table->increments('inventory_planner_id');
                $table->integer('inventory_type_id');
                $table->string('inventory_planner_title');
                $table->date('inventory_planner_deadline');
                $table->text('inventory_planner_desc');
                $table->char('inventory_planner_year', 4);
                $table->integer('flow_no');
                $table->integer('revision_no');
                $table->integer('current_user');
                $table->enum('active', ['0', '1'])->default('1');
                $table->integer('created_by');
                $table->integer('updated_by');
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
        Schema::dropIfExists('inventories_planner');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryPlannerEventPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('inventory_planner_event_prices')) {
            Schema::create('inventory_planner_event_prices', function (Blueprint $table) {
                $table->increments('inventory_planner_event_price_id');
                $table->integer('inventory_planner_id');
                $table->integer('price_type_id');
                $table->integer('media_id');
                $table->text('inventory_planner_event_price_remarks');
                $table->double('inventory_planner_event_price_gross_rate');
                $table->double('inventory_planner_event_price_surcharge');
                $table->double('inventory_planner_event_price_total_gross_rate');
                $table->double('inventory_planner_event_price_discount');
                $table->double('inventory_planner_event_price_nett_rate');
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
        Schema::dropIfExists('inventory_planner_event_prices');
    }
}

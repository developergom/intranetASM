<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSummaryItemsTableAddPoPerjanjianColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('summary_items')) {
            Schema::table('summary_items', function($table) {
                DB::statement("ALTER TABLE summary_items ADD summary_item_po_perjanjian VARCHAR(255) AFTER summary_item_sales_order");
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

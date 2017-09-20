<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSummaryItemsTableAddSummaryItemTerminAndSummaryItemViewedColumn extends Migration
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
                DB::statement('ALTER TABLE summary_items ADD summary_item_termin INTEGER AFTER summary_item_remarks');
                DB::statement('ALTER TABLE summary_items ADD summary_item_viewed ENUM("PROCESS","COMPLETED") DEFAULT "PROCESS" AFTER summary_item_termin');
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

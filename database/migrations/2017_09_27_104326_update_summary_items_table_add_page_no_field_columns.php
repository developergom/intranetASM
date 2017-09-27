<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSummaryItemsTableAddPageNoFieldColumns extends Migration
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
                DB::statement('ALTER TABLE summary_items ADD page_no INTEGER AFTER summary_item_remarks');
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

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSummaryItemsTableAddClientIdItemNameIndustryIdSalesId extends Migration
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
                DB::statement("ALTER TABLE summary_items ADD client_id INTEGER DEFAULT 0 AFTER summary_item_total");
                DB::statement("ALTER TABLE summary_items ADD summary_item_title VARCHAR(255) AFTER client_id");
                DB::statement("ALTER TABLE summary_items ADD industry_id INTEGER DEFAULT 0 AFTER summary_items_title");
                DB::statement("ALTER TABLE summary_items ADD sales_id INTEGER DEFAULT 0 AFTER industry_id");
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

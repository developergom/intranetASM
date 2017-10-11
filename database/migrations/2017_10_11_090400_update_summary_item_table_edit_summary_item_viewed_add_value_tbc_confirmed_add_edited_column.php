<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSummaryItemTableEditSummaryItemViewedAddValueTbcConfirmedAddEditedColumn extends Migration
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
                DB::statement("ALTER TABLE summary_items MODIFY COLUMN summary_item_viewed ENUM('PROCESS', 'COMPLETED', 'TBC', 'CONFIRMED')");
                DB::statement("ALTER TABLE summary_items ADD summary_item_edited ENUM('YES', 'NO') DEFAULT 'NO' AFTER summary_item_viewed");
                DB::statement("ALTER TABLE summary_items ADD source_type ENUM('SUMMARY', 'DIRECT') DEFAULT 'SUMMARY' AFTER summary_item_viewed");
                DB::statement('ALTER TABLE summary_items ADD COLUMN summary_item_canal VARCHAR(255) AFTER page_no, ADD COLUMN  summary_item_order_digital VARCHAR(255) AFTER summary_item_canal, ADD COLUMN summary_item_materi VARCHAR(255) AFTER summary_item_order_digital, ADD COLUMN summary_item_status_materi VARCHAR(255) AFTER summary_item_materi, ADD COLUMN summary_item_capture_materi VARCHAR(255) AFTER summary_item_status_materi, ADD COLUMN summary_item_sales_order VARCHAR(255) AFTER summary_item_capture_materi, ADD COLUMN summary_item_ppn DOUBLE AFTER summary_item_sales_order, ADD COLUMN summary_item_total DOUBLE AFTER summary_item_ppn, ADD COLUMN summary_item_task_status INTEGER AFTER summary_item_total');
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

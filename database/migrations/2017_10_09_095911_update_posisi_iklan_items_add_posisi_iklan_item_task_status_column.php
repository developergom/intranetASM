<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePosisiIklanItemsAddPosisiIklanItemTaskStatusColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('posisi_iklan_items')) {
            Schema::table('posisi_iklan_items', function($table) {
                DB::statement('ALTER TABLE posisi_iklan_items ADD posisi_iklan_item_task_status INTEGER DEFAULT 0 AFTER posisi_iklan_item_total');
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

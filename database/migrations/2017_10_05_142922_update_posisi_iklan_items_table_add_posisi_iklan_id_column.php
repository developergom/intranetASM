<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePosisiIklanItemsTableAddPosisiIklanIdColumn extends Migration
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
                DB::statement('ALTER TABLE posisi_iklan_items ADD posisi_iklan_id INTEGER AFTER posisi_iklan_item_id');
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

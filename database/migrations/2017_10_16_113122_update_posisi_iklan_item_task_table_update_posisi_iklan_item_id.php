<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePosisiIklanItemTaskTableUpdatePosisiIklanItemId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('posisi_iklan_item_tasks')) {
            Schema::table('posisi_iklan_item_tasks', function($table) {
                DB::statement("ALTER TABLE posisi_iklan_item_tasks CHANGE posisi_iklan_item_id summary_item_id INTEGER");
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

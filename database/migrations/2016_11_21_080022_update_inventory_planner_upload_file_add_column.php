<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInventoryPlannerUploadFileAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('inventory_planner_upload_file')) {
            Schema::table('inventory_planner_upload_file', function($table) {
                DB::statement('ALTER TABLE inventory_planner_upload_file ADD revision_no INTEGER AFTER upload_file_id');
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

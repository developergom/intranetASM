<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableMediaGroupsAddPublisherIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('media_groups')) {
            Schema::table('media_groups', function($table) {
                DB::statement('ALTER TABLE media_groups ADD publisher_id INTEGER AFTER media_group_id');
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

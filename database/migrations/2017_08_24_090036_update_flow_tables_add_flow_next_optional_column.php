<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFlowTablesAddFlowNextOptionalColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('flows')) {
            Schema::table('flows', function($table) {
                DB::statement("ALTER TABLE flows ADD flow_next_optional INTEGER DEFAULT 0 AFTER flow_next");
                DB::statement("ALTER TABLE flows ADD flow_using_optional ENUM('0','1') DEFAULT '0' AFTER flow_parallel");
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

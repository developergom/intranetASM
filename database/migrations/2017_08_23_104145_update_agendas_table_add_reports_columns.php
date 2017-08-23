<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAgendasTableAddReportsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('agendas')) {
            Schema::table('agendas', function($table) {
                DB::statement("ALTER TABLE agendas ADD agenda_is_report ENUM('0','1') DEFAULT '0' AFTER agenda_desc");
                DB::statement("ALTER TABLE agendas ADD agenda_meeting_time DATETIME NULL AFTER agenda_is_report");
                DB::statement("ALTER TABLE agendas ADD agenda_report_time DATETIME NULL AFTER agenda_meeting_time");
                DB::statement("ALTER TABLE agendas ADD agenda_report_desc TEXT NULL AFTER agenda_report_time");
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

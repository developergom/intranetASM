<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSummariesTableAddNotesColumnAfterTopCount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('summaries')) {
            Schema::table('summaries', function($table) {
                DB::statement('ALTER TABLE summaries ADD summary_notes TEXT AFTER top_count');
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

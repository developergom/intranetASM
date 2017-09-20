<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSummariesTableAddTotalMediaCostAndTotalCostPro extends Migration
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
                DB::statement('ALTER TABLE summaries ADD summary_total_media_cost DOUBLE AFTER summary_total_internal_omzet');
                DB::statement('ALTER TABLE summaries ADD summary_total_cost_pro DOUBLE AFTER summary_total_media_cost');
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

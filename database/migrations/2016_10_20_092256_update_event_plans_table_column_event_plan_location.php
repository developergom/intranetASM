<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
//use DB;

class UpdateEventPlansTableColumnEventPlanLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('event_plans')) {
            if (Schema::hasColumn('event_plans', 'event_plan_location')) {
                Schema::table('event_plans', function($table) {
                    DB::statement('ALTER TABLE event_plans CHANGE event_plan_location location_id INTEGER');
                });
            }
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

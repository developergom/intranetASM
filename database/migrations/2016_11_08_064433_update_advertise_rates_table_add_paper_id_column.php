<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAdvertiseRatesTableAddPaperIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('advertise_rates')) {
            Schema::table('advertise_rates', function($table) {
                DB::statement('ALTER TABLE advertise_rates ADD paper_id INTEGER AFTER advertise_size_id');
                DB::statement('ALTER TABLE advertise_rates ADD advertise_rate_startdate DATE AFTER advertise_rate_code');
                DB::statement('ALTER TABLE advertise_rates ADD advertise_rate_enddate DATE AFTER advertise_rate_startdate');
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

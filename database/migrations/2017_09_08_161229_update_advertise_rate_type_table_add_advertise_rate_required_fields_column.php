<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAdvertiseRateTypeTableAddAdvertiseRateRequiredFieldsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('advertise_rate_types')) {
            Schema::table('advertise_rate_types', function($table) {
                DB::statement('ALTER TABLE advertise_rate_types ADD advertise_rate_required_fields TEXT AFTER advertise_rate_type_name');
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

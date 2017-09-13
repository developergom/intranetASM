<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRatesTableAddParentIdColumnNotNull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('rates')) {
            Schema::table('rates', function($table) {
                DB::statement('ALTER TABLE rates ADD parent_id INTEGER NOT NULL AFTER rate_id');
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

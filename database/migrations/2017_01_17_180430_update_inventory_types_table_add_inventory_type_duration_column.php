<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateInventoryTypesTableAddInventoryTypeDurationColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('inventory_types')) {
            Schema::table('inventory_types', function($table) {
                DB::statement('ALTER TABLE inventory_types ADD inventory_type_duration INTEGER AFTER inventory_type_name');
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

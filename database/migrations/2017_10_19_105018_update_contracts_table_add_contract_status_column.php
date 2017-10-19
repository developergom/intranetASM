<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateContractsTableAddContractStatusColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('contracts')) {
            Schema::table('contracts', function($table) {
                DB::statement("ALTER TABLE contracts ADD contract_status ENUM('YES','NO') DEFAULT 'NO' AFTER contract_notes");
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

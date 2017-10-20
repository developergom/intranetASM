<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLettersTableAddLetterSourceColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('letters')) {
            Schema::table('letters', function($table) {
                DB::statement("ALTER TABLE letters ADD letter_source ENUM('ORDER','DIRECT') DEFAULT 'DIRECT' AFTER letter_notes");
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

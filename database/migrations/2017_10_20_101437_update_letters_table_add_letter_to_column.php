<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLettersTableAddLetterToColumn extends Migration
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
                DB::statement("ALTER TABLE letters ADD letter_to VARCHAR(255) AFTER letter_no");
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

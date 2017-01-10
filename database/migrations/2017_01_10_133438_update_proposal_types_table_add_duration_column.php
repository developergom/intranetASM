<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProposalTypesTableAddDurationColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('proposal_types')) {
            Schema::table('proposal_types', function($table) {
                DB::statement('ALTER TABLE proposal_types ADD proposal_type_duration INTEGER AFTER proposal_type_name');
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

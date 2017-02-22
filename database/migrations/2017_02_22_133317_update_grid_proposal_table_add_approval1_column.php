<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGridProposalTableAddApproval1Column extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('grid_proposals')) {
            Schema::table('grid_proposals', function($table) {
                DB::statement('ALTER TABLE grid_proposals ADD approval_1 INTEGER AFTER revision_no');
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

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProposalsTableAddProposalBudgetColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('proposals')) {
            Schema::table('proposals', function($table) {
                DB::statement('ALTER TABLE proposals ADD proposal_budget DOUBLE AFTER proposal_deadline');
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

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSummariesAndProposalTableAddParamNoColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('summaries')) {
            Schema::table('summaries', function($table) {
                DB::statement("ALTER TABLE summaries ADD param_no INTEGER AFTER summary_id");
            });
        }

        if (Schema::hasTable('proposals')) {
            Schema::table('proposals', function($table) {
                DB::statement("ALTER TABLE proposals ADD param_no INTEGER AFTER proposal_id");
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

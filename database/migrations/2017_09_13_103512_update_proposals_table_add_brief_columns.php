<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProposalsTableAddBriefColumns extends Migration
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
                DB::statement('ALTER TABLE proposals ADD proposal_background TEXT NULL AFTER proposal_desc');
                DB::statement('ALTER TABLE proposals ADD proposal_objective TEXT NULL AFTER proposal_desc');
                DB::statement('ALTER TABLE proposals ADD proposal_target_audience TEXT NULL AFTER proposal_desc');
                DB::statement('ALTER TABLE proposals ADD proposal_campaign_product TEXT NULL AFTER proposal_desc');
                DB::statement('ALTER TABLE proposals ADD proposal_mandatory TEXT NULL AFTER proposal_desc');
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

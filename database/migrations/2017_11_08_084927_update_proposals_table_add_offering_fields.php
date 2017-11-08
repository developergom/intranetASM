<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProposalsTableAddOfferingFields extends Migration
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
                DB::statement("ALTER TABLE proposals ADD proposal_cost DOUBLE DEFAULT 0 AFTER proposal_no");
                DB::statement("ALTER TABLE proposals ADD proposal_media_cost_print DOUBLE DEFAULT 0 AFTER proposal_cost");
                DB::statement("ALTER TABLE proposals ADD proposal_media_cost_other DOUBLE DEFAULT 0 AFTER proposal_media_cost_print");
                DB::statement("ALTER TABLE proposals ADD proposal_total_offering DOUBLE DEFAULT 0 AFTER proposal_media_cost_other");
                DB::statement("ALTER TABLE proposals ADD proposal_deal_cost DOUBLE DEFAULT 0 AFTER proposal_total_offering");
                DB::statement("ALTER TABLE proposals ADD proposal_deal_media_cost_print DOUBLE DEFAULT 0 AFTER proposal_deal_cost");
                DB::statement("ALTER TABLE proposals ADD proposal_deal_media_cost_other DOUBLE DEFAULT 0 AFTER proposal_deal_media_cost_print");
                DB::statement("ALTER TABLE proposals ADD proposal_total_deal DOUBLE DEFAULT 0 AFTER proposal_deal_media_cost_other");
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

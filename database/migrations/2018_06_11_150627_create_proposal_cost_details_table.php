<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalCostDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('proposal_cost_details')){
            Schema::create('proposal_cost_details', function(Blueprint $table){
                $table->increments('proposal_cost_details_id');
                $table->integer('proposal_id');
                $table->double('proposal_cost');
                $table->double('proposal_media_cost_print');
                $table->double('proposal_media_cost_other');
                $table->double('proposal_total_offering');
                $table->enum('status', ['0', '1'])->default('0');
                $table->integer('revision_no');
                $table->timestamps();
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
        Schema::dropIfExists('proposal_cost_details');
    }
}

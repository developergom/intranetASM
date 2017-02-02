<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGridProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('grid_proposals')) {
            Schema::create('grid_proposals', function (Blueprint $table) {
                $table->increments('grid_proposal_id');
                $table->string('grid_proposal_name');
                $table->date('grid_proposal_deadline');
                $table->text('grid_proposal_desc');
                $table->string('grid_proposal_no');
                $table->dateTime('grid_proposal_ready_date');
                $table->dateTime('grid_proposal_delivery_date');
                $table->integer('flow_no');
                $table->integer('revision_no');
                $table->integer('pic_1');
                $table->integer('pic_2');
                $table->integer('current_user');
                $table->enum('active', ['0', '1'])->default('1');
                $table->integer('created_by');
                $table->integer('updated_by');
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
        Schema::dropIfExists('grid_proposals');
    }
}

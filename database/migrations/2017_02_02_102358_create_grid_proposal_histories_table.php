<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGridProposalHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('grid_proposal_histories')) {
            Schema::create('grid_proposal_histories', function (Blueprint $table) {
                $table->increments('grid_proposal_history_id');
                $table->integer('grid_proposal_id');
                $table->integer('approval_type_id');
                $table->string('grid_proposal_history_text');
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
        Schema::dropIfExists('grid_proposal_histories');
    }
}

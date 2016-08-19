<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRkkProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('rkk_proposals')) {
            Schema::create('rkk_proposals', function (Blueprint $table) {
                $table->increments('rkk_proposal_id');
                $table->integer('module_id');
                $table->integer('proposal_type_id');
                $table->integer('rkk_proposal_day');
                $table->integer('rkk_proposal_value');
                $table->integer('rkk_proposal_poin');
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
        //
        Schema::dropIfExists('rkk_proposals');
    }
}

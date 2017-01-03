<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('proposals')) {
            Schema::create('proposals', function (Blueprint $table) {
                $table->increments('proposal_id');
                $table->integer('proposal_type_id');
                $table->string('proposal_name');
                $table->date('proposal_deadline');
                $table->text('proposal_desc');
                $table->string('proposal_no');
                $table->integer('proposal_status_id');
                $table->dateTime('proposal_ready_date');
                $table->dateTime('proposal_delivery_date');
                $table->integer('client_id');
                $table->integer('brand_id');
                $table->integer('flow_no');
                $table->integer('revision_no');
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
        Schema::dropIfExists('proposals');
    }
}

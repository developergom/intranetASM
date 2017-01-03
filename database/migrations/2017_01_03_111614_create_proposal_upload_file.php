<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalUploadFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('proposal_upload_file')) {
            Schema::create('proposal_upload_file', function (Blueprint $table) {
                $table->integer('proposal_id');
                $table->integer('upload_file_id');
                $table->integer('revision_no');
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
        Schema::dropIfExists('proposal_upload_file');
    }
}

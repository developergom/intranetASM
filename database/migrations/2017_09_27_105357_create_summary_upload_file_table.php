<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSummaryUploadFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('summary_upload_file')) {
            Schema::create('summary_upload_file', function (Blueprint $table) {
                $table->integer('summary_id');
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
        Schema::dropIfExists('summary_upload_file');
    }
}

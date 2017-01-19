<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTaskUploadFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('project_task_upload_file')) {
            Schema::create('project_task_upload_file', function (Blueprint $table) {
                $table->integer('project_task_id');
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
        Schema::dropIfExists('project_task_upload_file');
    }
}

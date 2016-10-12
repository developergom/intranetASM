<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventPlanUploadFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('event_plan_upload_file')) {
            Schema::create('event_plan_upload_file', function (Blueprint $table) {
                $table->integer('event_plan_id');
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
        Schema::dropIfExists('event_plan_upload_file');
    }
}

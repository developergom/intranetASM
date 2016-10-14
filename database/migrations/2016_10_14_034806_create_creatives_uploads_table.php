<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreativesUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('creative_upload_file')) {
            Schema::create('creative_upload_file', function (Blueprint $table) {
                $table->integer('creative_id');
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
        Schema::dropIfExists('creative_upload_file');
    }
}

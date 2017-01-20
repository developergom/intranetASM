<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUploadFilesTableAddUploadFileRevisionColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('upload_files')) {
            Schema::table('upload_files', function($table) {
                DB::statement('ALTER TABLE upload_files ADD upload_file_revision INTEGER AFTER upload_file_size');
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
    }
}

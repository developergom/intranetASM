<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('upload_files')) {     
            Schema::create('upload_files', function (Blueprint $table) {
                $table->increments('upload_file_id');
                $table->string('upload_file_type');
                $table->string('upload_file_name');
                $table->string('upload_file_path');
                $table->string('upload_file_size');
                $table->text('upload_file_desc');
                $table->enum('active',['0','1'])->default('1');
                $table->integer('created_by');
                $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('upload_files');
    }
}

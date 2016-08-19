<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('medias')) {
            Schema::create('medias', function (Blueprint $table) {
                $table->increments('media_id');
                $table->integer('media_group_id');
                $table->integer('media_category_id');
                $table->char('media_code', 12);
                $table->string('media_name', 100);
                $table->string('media_logo', 255);
                $table->text('media_desc')->nullable();
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
        Schema::dropIfExists('medias');
    }
}

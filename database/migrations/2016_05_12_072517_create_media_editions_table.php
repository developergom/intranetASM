<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaEditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('media_editions')) {
            Schema::create('media_editions', function (Blueprint $table) {
                $table->increments('media_edition_id');
                $table->integer('media_id');
                $table->string('media_edition_no', 50);
                $table->date('media_edition_publish_date');
                $table->date('media_edition_deadline_date');
                $table->text('media_edition_desc')->nullable();
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
        Schema::dropIfExists('media_editions');
    }
}

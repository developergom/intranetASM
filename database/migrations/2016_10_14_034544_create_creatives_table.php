<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('creatives')) {
            Schema::create('creatives', function (Blueprint $table) {
                $table->increments('creative_id');
                $table->integer('creative_format_id');
                $table->string('creative_name');
                $table->integer('media_category_id');
                $table->text('creative_desc');
                $table->decimal('creative_width');
                $table->decimal('creative_height');
                $table->integer('unit_id');
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
        Schema::dropIfExists('creatives');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionPlanMediaEditionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        if (!Schema::hasTable('action_plan_media_edition')) {
            Schema::create('action_plan_media_edition', function (Blueprint $table) {
                $table->integer('action_plan_id');
                $table->integer('media_edition_id');
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
        Schema::dropIfExists('action_plan_media_edition');
    }
}

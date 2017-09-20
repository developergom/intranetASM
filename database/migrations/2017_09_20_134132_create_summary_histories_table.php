<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSummaryHistoriesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('summary_histories')) {
            Schema::create('summary_histories', function (Blueprint $table) {
                $table->increments('summary_history_id');
                $table->integer('summary_id');
                $table->integer('approval_type_id');
                $table->text('summary_history_text');
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
        Schema::dropIfExists('summary_histories');
    }
}

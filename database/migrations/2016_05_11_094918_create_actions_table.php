<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('actions')) {
            Schema::create('actions', function (Blueprint $table) {
                $table->increments('action_id');
                $table->string('action_name', 100);
                $table->string('action_alias', 50);
                $table->text('action_desc')->nullable();
                $table->enum('active', ['0','1'])->default('1');
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
        //
        Schema::dropIfExists('actions');
    }
}

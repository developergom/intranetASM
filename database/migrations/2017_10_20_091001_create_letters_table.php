<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('letters')) {
            Schema::create('letters', function (Blueprint $table) {
                $table->increments('letter_id');
                $table->integer('param_no');
                $table->integer('letter_type_id');
                $table->string('letter_no', 50);
                $table->text('letter_notes');
                $table->integer('revision_no');
                $table->integer('current_user');
                $table->integer('flow_no');
                $table->integer('pic');
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
        Schema::dropIfExists('letters');
    }
}

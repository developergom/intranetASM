<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('advertise_positions', function (Blueprint $table) {
            $table->increments('advertise_position_id');
            $table->string('advertise_position_name', 100);
            $table->text('advertise_position_desc')->nullable();
            $table->enum('active', ['0', '1'])->default('1');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('advertise_positions');
    }
}

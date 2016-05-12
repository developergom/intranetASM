<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertiseRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('advertise_rates', function (Blueprint $table) {
            $table->increments('advertise_rate_id');
            $table->integer('media_id');
            $table->integer('advertise_position_id');
            $table->integer('advertise_size_id');
            $table->char('advertise_rate_code', 15);
            $table->float('advertise_rate_normal');
            $table->float('advertise_rate_discount');
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
        Schema::dropIfExists('advertise_rates');
    }
}

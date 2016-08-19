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
        if (!Schema::hasTable('advertise_rates')) {
            Schema::create('advertise_rates', function (Blueprint $table) {
                $table->increments('advertise_rate_id');
                $table->integer('media_id');
                $table->integer('advertise_position_id');
                $table->integer('advertise_size_id');
                $table->char('advertise_rate_code', 15);
                $table->double('advertise_rate_normal', 15, 8);
                $table->double('advertise_rate_discount', 15, 8);
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
        Schema::dropIfExists('advertise_rates');
    }
}

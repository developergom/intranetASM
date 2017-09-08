<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('rates')) {
            Schema::create('rates', function (Blueprint $table) {
                $table->increments('rate_id');
                $table->integer('advertise_rate_type_id');
                $table->integer('media_id');
                $table->string('rate_name');
                $table->float('width');
                $table->float('length');
                $table->integer('unit_id');
                $table->integer('studio_id');
                $table->integer('duration');
                $table->enum('duration_type',['second', 'minute', 'hour']);
                $table->integer('spot_type_id');
                $table->double('gross_rate');
                $table->integer('discount');
                $table->double('nett_rate');
                $table->date('start_valid_date');
                $table->date('end_valid_date');
                $table->double('cinema_tax');
                $table->integer('paper_id');
                $table->integer('color_id');
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
        Schema::dropIfExists('rates');
    }
}

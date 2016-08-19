<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertiseSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('advertise_sizes')) {
            Schema::create('advertise_sizes', function (Blueprint $table) {
                $table->increments('advertise_size_id');
                $table->char('advertise_size_code', 10);
                $table->string('advertise_size_name', 100);
                $table->text('advertise_size_desc')->nullable();
                $table->integer('unit_id');
                $table->float('advertise_size_width');
                $table->float('advertise_size_length');
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
        Schema::dropIfExists('advertise_sizes');
    }
}

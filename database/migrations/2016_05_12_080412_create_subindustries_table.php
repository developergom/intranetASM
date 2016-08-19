<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubindustriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('subindustries')) {
            Schema::create('subindustries', function (Blueprint $table) {
                $table->increments('subindustry_id');
                $table->integer('industry_id');
                $table->char('subindustry_code', 10);
                $table->string('subindustry_name', 100);
                $table->text('subindustry_desc')->nullable();
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
        Schema::dropIfExists('subindustries');
    }
}

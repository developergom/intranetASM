<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('configs')) {
            Schema::create('configs', function (Blueprint $table) {
                $table->increments('config_id');
                $table->string('config_key', 100)->unique();
                $table->string('config_value');
                $table->text('config_desc')->nullable();
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
        Schema::dropIfExists('configs');
    }
}

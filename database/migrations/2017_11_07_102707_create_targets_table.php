<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if (!Schema::hasTable('targets')) {
            Schema::create('targets', function (Blueprint $table) {
                $table->increments('target_id');
                $table->string('target_code', 20);
                $table->char('target_month', 2);
                $table->char('target_year', 4);
                $table->integer('media_id');
                $table->integer('industry_id');
                $table->double('target_amount');
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
        Schema::dropIfExists('targets');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePapers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('papers')) {
            Schema::create('papers', function (Blueprint $table) {
                $table->increments('paper_id');
                $table->integer('unit_id');
                $table->string('paper_name', 100);
                $table->float('paper_width');
                $table->float('paper_length');
                $table->text('paper_desc')->nullable();
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
        Schema::dropIfExists('papers');
    }
}

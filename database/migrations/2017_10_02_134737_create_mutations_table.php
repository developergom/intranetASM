<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMutationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('mutations')) {
            Schema::create('mutations', function (Blueprint $table) {
                $table->increments('mutation_id');
                $table->integer('mutation_from');
                $table->integer('mutation_to');
                $table->text('mutation_desc')->nullable();
                $table->integer('module_id');
                $table->integer('mutation_item_id');
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
        Schema::dropIfExists('mutations');
    }
}

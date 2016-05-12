<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('inventory_types', function (Blueprint $table) {
            $table->increments('inventory_type_id');
            $table->string('inventory_type_name');
            $table->text('inventory_type_desc')->nullable();
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
        Schema::dropIfExists('inventory_types');
    }
}

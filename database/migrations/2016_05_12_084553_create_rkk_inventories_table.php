<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRkkInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('rkk_inventories')) {
            Schema::create('rkk_inventories', function (Blueprint $table) {
                $table->increments('rkk_inventory_id');
                $table->integer('module_id');
                $table->integer('inventory_type_id');
                $table->integer('rkk_inventory_day');
                $table->integer('rkk_inventory_value');
                $table->integer('rkk_inventory_poin');
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
        Schema::dropIfExists('rkk_inventories');
    }
}

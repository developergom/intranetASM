<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosisiIklanItemTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('posisi_iklan_item_tasks')) {
            Schema::create('posisi_iklan_item_tasks', function (Blueprint $table) {
                $table->increments('posisi_iklan_item_task_id');
                $table->integer('posisi_iklan_item_id');
                $table->integer('posisi_iklan_item_task_pic');
                $table->enum('posisi_iklan_item_task_status', ['ON PROCESS', 'FINISHED'])->default('ON PROCESS');
                $table->datetime('posisi_iklan_item_task_finish_time');
                $table->text('posisi_iklan_item_task_notes');
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
        Schema::dropIfExists('posisi_iklan_item_tasks');
    }
}

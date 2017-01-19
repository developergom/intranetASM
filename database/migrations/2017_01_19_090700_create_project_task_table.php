<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('project_tasks')) {
            Schema::create('project_tasks', function (Blueprint $table) {
                $table->increments('project_task_id');
                $table->integer('project_task_type_id');
                $table->integer('project_id');
                $table->string('project_task_name');
                $table->date('project_task_deadline');
                $table->text('project_task_desc');
                $table->string('project_task_no');
                $table->integer('project_task_status_id');
                $table->dateTime('project_task_ready_date');
                $table->dateTime('project_task_delivery_date');
                $table->integer('flow_no');
                $table->integer('revision_no');
                $table->integer('pic');
                $table->integer('current_user');
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
        Schema::dropIfExists('project_tasks');
    }
}

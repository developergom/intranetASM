<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlowGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('flow_groups')) {
            Schema::create('flow_groups', function (Blueprint $table) {
                $table->increments('flow_group_id');
                $table->integer('module_id');
                $table->string('flow_group_name');
                $table->text('flow_group_desc')->nullable();
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
        Schema::dropIfExists('flow_groups');
    }
}

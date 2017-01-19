<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('flows')) {
            Schema::create('flows', function (Blueprint $table) {
                $table->increments('flow_id');
                $table->integer('flow_group_id');
                $table->string('flow_name', 100);
                $table->string('flow_url', 255);
                $table->integer('flow_no');
                $table->integer('flow_prev');
                $table->integer('flow_next');
                $table->integer('role_id');
                $table->enum('flow_by', ['AUTHOR', 'GROUP', 'INDUSTRY', 'PIC', 'MEDIA', 'MANUAL']);
                $table->enum('flow_parallel', ['true', 'false'])->default('false');
                $table->enum('flow_condition', ['EQUAL','NOT_EQUAL','GREATER','LESS','GREATER_EQUAL','LESS_EQUAL']);
                $table->integer('flow_condition_value');
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
        Schema::dropIfExists('flows');
    }
}

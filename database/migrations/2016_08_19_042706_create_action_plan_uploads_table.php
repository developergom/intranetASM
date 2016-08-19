<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionPlanUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('action_plan_uploads')) {
            Schema::create('action_plan_uploads', function (Blueprint $table) {
                $table->increments('action_plain_upload_id');
                $table->integer('action_plan_id');
                $table->string('action_plan_upload_file_name', 255);
                $table->string('action_plan_upload_file_location', 255);
                $table->enum('active',['0','1'])->default('1');
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
        Schema::dropIfExists('action_plan_uploads');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('media_groups')) {
            Schema::create('media_groups', function (Blueprint $table) {
                $table->increments('media_group_id');
                $table->char('media_group_code', 5)->unique();
                $table->string('media_group_name', 100);
                $table->text('media_group_desc')->nullable();
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
        Schema::dropIfExists('media_groups');
    }
}

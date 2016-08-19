<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('roles_modules')) {
            Schema::create('roles_modules', function (Blueprint $table) {
                $table->integer('role_id');
                $table->integer('module_id');
                $table->integer('action_id');
                $table->integer('access');
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
        Schema::dropIfExists('roles_modules');
    }
}
